<?php
class Tango_acl{
	protected $_class;
	public function __construct(){
		$this->_class = new Zend_Acl();
	}

	public function addRole($role, $parent=''){
		if ($parent!='') {
			$this->_class->addRole(new Zend_Acl_Role($role), $parent);
		} else {
			$this->_class->addRole(new Zend_Acl_Role($role));
		}
		return $this;
	}

	public function addResourse($resourse, $parent=''){
		if ($parent!='') {
			$this->_class->add(new Zend_Acl_Resource($resourse), $parent);
		} else {
			$this->_class->add(new Zend_Acl_Resource($resourse));
		}
		return $this;
	}
	
	public function allow($role, $resourse='', $action=''){
		if ($action!='') {
			$this->_class->allow($role, $resourse, $action);
		}else{
			if ($resourse!='') {
				$this->_class->allow($role, $resourse);
			}else{
				$this->_class->allow($role);
			}
		}
		return $this;
	}

	public function isAllowed($role, $resourse, $action='view'){
		return $this->_class->isAllowed($role, $resourse, $action);
	}
}

/*****************************************************************************************/
class Zend_Exception extends Exception{
    private $_previous = null;
    public function __construct($msg = '', $code = 0, Exception $previous = null){
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            parent::__construct($msg, (int) $code);
            $this->_previous = $previous;
        } else {
            parent::__construct($msg, (int) $code, $previous);
        }
    }
    public function __call($method, array $args){
        if ('getprevious' == strtolower($method)) {
            return $this->_getPrevious();
        }
        return null;
    }
    public function __toString(){
        if (version_compare(PHP_VERSION, '5.3.0', '<')) {
            if (null !== ($e = $this->getPrevious())) {
                return $e->__toString()
                       . "\n\nNext "
                       . parent::__toString();
            }
        }
        return parent::__toString();
    }
    protected function _getPrevious(){
        return $this->_previous;
    }
}
class Zend_Acl_Exception extends Zend_Exception{}
class Zend_Acl_Role_Registry_Exception extends Zend_Acl_Exception{}
class Zend_Acl{
    const TYPE_ALLOW = 'TYPE_ALLOW';
    const TYPE_DENY  = 'TYPE_DENY';
    const OP_ADD = 'OP_ADD';
    const OP_REMOVE = 'OP_REMOVE';
    protected $_roleRegistry = null;
    protected $_resources = array();
    protected $_isAllowedRole     = null;
    protected $_isAllowedResource = null;
    protected $_isAllowedPrivilege = null;
    protected $_rules = array(
        'allResources' => array(
            'allRoles' => array(
                'allPrivileges' => array(
                    'type'   => self::TYPE_DENY,
                    'assert' => null
                    ),
                'byPrivilegeId' => array()
                ),
            'byRoleId' => array()
            ),
        'byResourceId' => array()
        );
    public function addRole($role, $parents = null){
        if (is_string($role)) {
            $role = new Zend_Acl_Role($role);
        }
        $this->_getRoleRegistry()->add($role, $parents);
        return $this;
    }
    public function getRole($role){
        return $this->_getRoleRegistry()->get($role);
    }
    public function hasRole($role){
        return $this->_getRoleRegistry()->has($role);
    }
    public function inheritsRole($role, $inherit, $onlyParents = false){
        return $this->_getRoleRegistry()->inherits($role, $inherit, $onlyParents);
    }
    public function removeRole($role){
        $this->_getRoleRegistry()->remove($role);
        $roleId = $role;
        foreach ($this->_rules['allResources']['byRoleId'] as $roleIdCurrent => $rules) {
            if ($roleId === $roleIdCurrent) {
                unset($this->_rules['allResources']['byRoleId'][$roleIdCurrent]);
            }
        }
        foreach ($this->_rules['byResourceId'] as $resourceIdCurrent => $visitor) {
            if (array_key_exists('byRoleId', $visitor)) {
                foreach ($visitor['byRoleId'] as $roleIdCurrent => $rules) {
                    if ($roleId === $roleIdCurrent) {
                        unset($this->_rules['byResourceId'][$resourceIdCurrent]['byRoleId'][$roleIdCurrent]);
                    }
                }
            }
        }
        return $this;
    }
    public function removeRoleAll(){
        $this->_getRoleRegistry()->removeAll();
        foreach ($this->_rules['allResources']['byRoleId'] as $roleIdCurrent => $rules) {
            unset($this->_rules['allResources']['byRoleId'][$roleIdCurrent]);
        }
        foreach ($this->_rules['byResourceId'] as $resourceIdCurrent => $visitor) {
            foreach ($visitor['byRoleId'] as $roleIdCurrent => $rules) {
                unset($this->_rules['byResourceId'][$resourceIdCurrent]['byRoleId'][$roleIdCurrent]);
            }
        }
        return $this;
    }
    public function addResource($resource, $parent = null){
        if (is_string($resource)) {
            $resource = new Zend_Acl_Resource($resource);
        }
        if (!$resource) {
            throw new Zend_Acl_Exception('addResource() expects $resource to be of type Zend_Acl_Resource_Interface');
        }
        $resourceId = $resource->getResourceId();
        if ($this->has($resourceId)) {
            throw new Zend_Acl_Exception("Resource id '$resourceId' already exists in the ACL");
        }
        $resourceParent = null;
        if (null !== $parent) {
            try {
                $resourceParentId = $parent;
                $resourceParent = $this->get($resourceParentId);
            } catch (Zend_Acl_Exception $e) {
                throw new Zend_Acl_Exception("Parent Resource id '$resourceParentId' does not exist", 0, $e);
            }
            $this->_resources[$resourceParentId]['children'][$resourceId] = $resource;
        }
        $this->_resources[$resourceId] = array(
            'instance' => $resource,
            'parent'   => $resourceParent,
            'children' => array()
            );
        return $this;
    }
    public function add($resource, $parent = null){
        return $this->addResource($resource, $parent);
    }
    public function get($resource){
        $resourceId = (string) $resource;
        if (!$this->has($resource)) {
            throw new Zend_Acl_Exception("Resource '$resourceId' not found");
        }
        return $this->_resources[$resourceId]['instance'];
    }
    public function has($resource){
        $resourceId = (string) $resource;
        return isset($this->_resources[$resourceId]);
    }
    public function inherits($resource, $inherit, $onlyParent = false){
        try {
            $resourceId     = $this->get($resource)->getResourceId();
            $inheritId = $this->get($inherit)->getResourceId();
        } catch (Zend_Acl_Exception $e) {
            throw new Zend_Acl_Exception($e->getMessage(), $e->getCode(), $e);
        }
        if (null !== $this->_resources[$resourceId]['parent']) {
            $parentId = $this->_resources[$resourceId]['parent']->getResourceId();
            if ($inheritId === $parentId) {
                return true;
            } else if ($onlyParent) {
                return false;
            }
        } else {
            return false;
        }
        while (null !== $this->_resources[$parentId]['parent']) {
            $parentId = $this->_resources[$parentId]['parent']->getResourceId();
            if ($inheritId === $parentId) {
                return true;
            }
        }
        return false;
    }
    public function remove($resource){
        try {
            $resourceId = $this->get($resource)->getResourceId();
        } catch (Zend_Acl_Exception $e) {
            throw new Zend_Acl_Exception($e->getMessage(), $e->getCode(), $e);
        }
        $resourcesRemoved = array($resourceId);
        if (null !== ($resourceParent = $this->_resources[$resourceId]['parent'])) {
            unset($this->_resources[$resourceParent->getResourceId()]['children'][$resourceId]);
        }
        foreach ($this->_resources[$resourceId]['children'] as $childId => $child) {
            $this->remove($childId);
            $resourcesRemoved[] = $childId;
        }
        foreach ($resourcesRemoved as $resourceIdRemoved) {
            foreach ($this->_rules['byResourceId'] as $resourceIdCurrent => $rules) {
                if ($resourceIdRemoved === $resourceIdCurrent) {
                    unset($this->_rules['byResourceId'][$resourceIdCurrent]);
                }
            }
        }
        unset($this->_resources[$resourceId]);
        return $this;
    }
    public function removeAll(){
        foreach ($this->_resources as $resourceId => $resource) {
            foreach ($this->_rules['byResourceId'] as $resourceIdCurrent => $rules) {
                if ($resourceId === $resourceIdCurrent) {
                    unset($this->_rules['byResourceId'][$resourceIdCurrent]);
                }
            }
        }
        $this->_resources = array();
        return $this;
    }
    public function allow($roles = null, $resources = null, $privileges = null, $assert = null){
        return $this->setRule(self::OP_ADD, self::TYPE_ALLOW, $roles, $resources, $privileges, $assert);
    }
    public function deny($roles = null, $resources = null, $privileges = null, $assert = null){
        return $this->setRule(self::OP_ADD, self::TYPE_DENY, $roles, $resources, $privileges, $assert);
    }
    public function removeAllow($roles = null, $resources = null, $privileges = null){
        return $this->setRule(self::OP_REMOVE, self::TYPE_ALLOW, $roles, $resources, $privileges);
    }
    public function removeDeny($roles = null, $resources = null, $privileges = null){
        return $this->setRule(self::OP_REMOVE, self::TYPE_DENY, $roles, $resources, $privileges);
    }
    public function setRule($operation, $type, $roles = null, $resources = null, $privileges = null, $assert = null){
        // ensure that the rule type is valid; normalize input to uppercase
        $type = strtoupper($type);
        if (self::TYPE_ALLOW !== $type && self::TYPE_DENY !== $type) {
            throw new Zend_Acl_Exception("Unsupported rule type; must be either '" . self::TYPE_ALLOW . "' or '"
                                       . self::TYPE_DENY . "'");
        }
        // ensure that all specified Roles exist; normalize input to array of Role objects or null
        if (!is_array($roles)) {
            $roles = array($roles);
        } else if (0 === count($roles)) {
            $roles = array(null);
        }
        $rolesTemp = $roles;
        $roles = array();
        foreach ($rolesTemp as $role) {
            if (null !== $role) {
                $roles[] = $this->_getRoleRegistry()->get($role);
            } else {
                $roles[] = null;
            }
        }
        unset($rolesTemp);
        // ensure that all specified Resources exist; normalize input to array of Resource objects or null
        if ($resources !== null) {
            if (!is_array($resources)) {
                $resources = array($resources);
            } else if (0 === count($resources)) {
                $resources = array(null);
            }
            $resourcesTemp = $resources;
            $resources = array();
            foreach ($resourcesTemp as $resource) {
                if (null !== $resource) {
                    $resources[] = $this->get($resource);
                } else {
                    $resources[] = null;
                }
            }
            unset($resourcesTemp, $resource);
        } else {
            $allResources = array(); // this might be used later if resource iteration is required
            foreach ($this->_resources as $rTarget) {
                $allResources[] = $rTarget['instance'];
            }
            unset($rTarget);
        }
        // normalize privileges to array
        if (null === $privileges) {
            $privileges = array();
        } else if (!is_array($privileges)) {
            $privileges = array($privileges);
        }
        switch ($operation) {
            // add to the rules
            case self::OP_ADD:
                if ($resources !== null) {
                    // this block will iterate the provided resources
                    foreach ($resources as $resource) {
                        foreach ($roles as $role) {
                            $rules =& $this->_getRules($resource, $role, true);
                            if (0 === count($privileges)) {
                                $rules['allPrivileges']['type']   = $type;
                                $rules['allPrivileges']['assert'] = $assert;
                                if (!isset($rules['byPrivilegeId'])) {
                                    $rules['byPrivilegeId'] = array();
                                }
                            } else {
                                foreach ($privileges as $privilege) {
                                    $rules['byPrivilegeId'][$privilege]['type']   = $type;
                                    $rules['byPrivilegeId'][$privilege]['assert'] = $assert;
                                }
                            }
                        }
                    }
                } else {
                    // this block will apply to all resources in a global rule
                    foreach ($roles as $role) {
                        $rules =& $this->_getRules(null, $role, true);
                        if (0 === count($privileges)) {
                            $rules['allPrivileges']['type']   = $type;
                            $rules['allPrivileges']['assert'] = $assert;
                        } else {
                            foreach ($privileges as $privilege) {
                                $rules['byPrivilegeId'][$privilege]['type']   = $type;
                                $rules['byPrivilegeId'][$privilege]['assert'] = $assert;
                            }
                        }
                    }
                }
                break;
            // remove from the rules
            case self::OP_REMOVE:
                if ($resources !== null) {
                    // this block will iterate the provided resources
                    foreach ($resources as $resource) {
                        foreach ($roles as $role) {
                            $rules =& $this->_getRules($resource, $role);
                            if (null === $rules) {
                                continue;
                            }
                            if (0 === count($privileges)) {
                                if (null === $resource && null === $role) {
                                    if ($type === $rules['allPrivileges']['type']) {
                                        $rules = array(
                                            'allPrivileges' => array(
                                                'type'   => self::TYPE_DENY,
                                                'assert' => null
                                                ),
                                            'byPrivilegeId' => array()
                                            );
                                    }
                                    continue;
                                }
                                if (isset($rules['allPrivileges']['type']) &&
                                    $type === $rules['allPrivileges']['type'])
                                {
                                    unset($rules['allPrivileges']);
                                }
                            } else {
                                foreach ($privileges as $privilege) {
                                    if (isset($rules['byPrivilegeId'][$privilege]) &&
                                        $type === $rules['byPrivilegeId'][$privilege]['type'])
                                    {
                                        unset($rules['byPrivilegeId'][$privilege]);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    // this block will apply to all resources in a global rule
                    foreach ($roles as $role) {
                        /**
                         * since null (all resources) was passed to this setRule() call, we need
                         * clean up all the rules for the global allResources, as well as the indivually
                         * set resources (per privilege as well)
                         */
                        foreach (array_merge(array(null), $allResources) as $resource) {
                            $rules =& $this->_getRules($resource, $role, true);
                            if (null === $rules) {
                                continue;
                            }
                            if (0 === count($privileges)) {
                                if (null === $role) {
                                    if ($type === $rules['allPrivileges']['type']) {
                                        $rules = array(
                                            'allPrivileges' => array(
                                                'type'   => self::TYPE_DENY,
                                                'assert' => null
                                                ),
                                            'byPrivilegeId' => array()
                                            );
                                    }
                                    continue;
                                }

                                if (isset($rules['allPrivileges']['type']) && $type === $rules['allPrivileges']['type']) {
                                    unset($rules['allPrivileges']);
                                }
                            } else {
                                foreach ($privileges as $privilege) {
                                    if (isset($rules['byPrivilegeId'][$privilege]) &&
                                        $type === $rules['byPrivilegeId'][$privilege]['type'])
                                    {
                                        unset($rules['byPrivilegeId'][$privilege]);
                                    }
                                }
                            }
                        }
                    }
                }
                break;

            default:
                throw new Zend_Acl_Exception("Unsupported operation; must be either '" . self::OP_ADD . "' or '"
                                           . self::OP_REMOVE . "'");
        }
        return $this;
    }
    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        // reset role & resource to null
        $this->_isAllowedRole = null;
        $this->_isAllowedResource = null;
        $this->_isAllowedPrivilege = null;

        if (null !== $role) {
            // keep track of originally called role
            $this->_isAllowedRole = $role;
            $role = $this->_getRoleRegistry()->get($role);
            $this->_isAllowedRole = $role;
        }

        if (null !== $resource) {
            // keep track of originally called resource
            $this->_isAllowedResource = $resource;
            $resource = $this->get($resource);
            $this->_isAllowedResource = $resource;
        }

        if (null === $privilege) {
            // query on all privileges
            do {
                // depth-first search on $role if it is not 'allRoles' pseudo-parent
                if (null !== $role && null !== ($result = $this->_roleDFSAllPrivileges($role, $resource, $privilege))) {
                    return $result;
                }

                // look for rule on 'allRoles' psuedo-parent
                if (null !== ($rules = $this->_getRules($resource, null))) {
                    foreach ($rules['byPrivilegeId'] as $privilege => $rule) {
                        if (self::TYPE_DENY === ($ruleTypeOnePrivilege = $this->_getRuleType($resource, null, $privilege))) {
                            return false;
                        }
                    }
                    if (null !== ($ruleTypeAllPrivileges = $this->_getRuleType($resource, null, null))) {
                        return self::TYPE_ALLOW === $ruleTypeAllPrivileges;
                    }
                }

                // try next Resource
                $resource = $this->_resources[$resource->getResourceId()]['parent'];

            } while (true); // loop terminates at 'allResources' pseudo-parent
        } else {
            $this->_isAllowedPrivilege = $privilege;
            // query on one privilege
            do {
                // depth-first search on $role if it is not 'allRoles' pseudo-parent
                if (null !== $role && null !== ($result = $this->_roleDFSOnePrivilege($role, $resource, $privilege))) {
                    return $result;
                }

                // look for rule on 'allRoles' pseudo-parent
                if (null !== ($ruleType = $this->_getRuleType($resource, null, $privilege))) {
                    return self::TYPE_ALLOW === $ruleType;
                } else if (null !== ($ruleTypeAllPrivileges = $this->_getRuleType($resource, null, null))) {
                    return self::TYPE_ALLOW === $ruleTypeAllPrivileges;
                }

                // try next Resource
                $resource = $this->_resources[$resource->getResourceId()]['parent'];

            } while (true); // loop terminates at 'allResources' pseudo-parent
        }
    }
    protected function _getRoleRegistry()
    {
        if (null === $this->_roleRegistry) {
            $this->_roleRegistry = new Zend_Acl_Role_Registry();
        }
        return $this->_roleRegistry;
    }

    protected function _roleDFSAllPrivileges($role, $resource = null)
    {
        $dfs = array(
            'visited' => array(),
            'stack'   => array()
            );

        if (null !== ($result = $this->_roleDFSVisitAllPrivileges($role, $resource, $dfs))) {
            return $result;
        }

        while (null !== ($role = array_pop($dfs['stack']))) {
            if (!isset($dfs['visited'][$role->getRoleId()])) {
                if (null !== ($result = $this->_roleDFSVisitAllPrivileges($role, $resource, $dfs))) {
                    return $result;
                }
            }
        }

        return null;
    }
    protected function _roleDFSVisitAllPrivileges($role, $resource = null,  &$dfs = null){
        if (null === $dfs) {
            /**
             * @see Zend_Acl_Exception
             */
            throw new Zend_Acl_Exception('$dfs parameter may not be null');
        }

        if (null !== ($rules = $this->_getRules($resource, $role))) {
            foreach ($rules['byPrivilegeId'] as $privilege => $rule) {
                if (self::TYPE_DENY === ($ruleTypeOnePrivilege = $this->_getRuleType($resource, $role, $privilege))) {
                    return false;
                }
            }
            if (null !== ($ruleTypeAllPrivileges = $this->_getRuleType($resource, $role, null))) {
                return self::TYPE_ALLOW === $ruleTypeAllPrivileges;
            }
        }

        $dfs['visited'][$role->getRoleId()] = true;
        foreach ($this->_getRoleRegistry()->getParents($role) as $roleParentId => $roleParent) {
            $dfs['stack'][] = $roleParent;
        }

        return null;
    }
    protected function _roleDFSOnePrivilege($role, $resource = null,  $privilege = null){
        if (null === $privilege) {
            /**
             * @see Zend_Acl_Exception
             */
            throw new Zend_Acl_Exception('$privilege parameter may not be null');
        }

        $dfs = array(
            'visited' => array(),
            'stack'   => array()
            );

        if (null !== ($result = $this->_roleDFSVisitOnePrivilege($role, $resource, $privilege, $dfs))) {
            return $result;
        }

        while (null !== ($role = array_pop($dfs['stack']))) {
            if (!isset($dfs['visited'][$role->getRoleId()])) {
                if (null !== ($result = $this->_roleDFSVisitOnePrivilege($role, $resource, $privilege, $dfs))) {
                    return $result;
                }
            }
        }

        return null;
    }
    protected function _roleDFSVisitOnePrivilege($role, $resource = null, $privilege = null, &$dfs = null){
        if (null === $privilege) {
            /**
             * @see Zend_Acl_Exception
             */
            throw new Zend_Acl_Exception('$privilege parameter may not be null');
        }

        if (null === $dfs) {
            /**
             * @see Zend_Acl_Exception
             */
            throw new Zend_Acl_Exception('$dfs parameter may not be null');
        }

        if (null !== ($ruleTypeOnePrivilege = $this->_getRuleType($resource, $role, $privilege))) {
            return self::TYPE_ALLOW === $ruleTypeOnePrivilege;
        } else if (null !== ($ruleTypeAllPrivileges = $this->_getRuleType($resource, $role, null))) {
            return self::TYPE_ALLOW === $ruleTypeAllPrivileges;
        }

        $dfs['visited'][$role->getRoleId()] = true;
        foreach ($this->_getRoleRegistry()->getParents($role) as $roleParentId => $roleParent) {
            $dfs['stack'][] = $roleParent;
        }

        return null;
    }
    protected function _getRuleType($resource = null, $role = null, $privilege = null){
        // get the rules for the $resource and $role
        if (null === ($rules = $this->_getRules($resource, $role))) {
            return null;
        }

        // follow $privilege
        if (null === $privilege) {
            if (isset($rules['allPrivileges'])) {
                $rule = $rules['allPrivileges'];
            } else {
                return null;
            }
        } else if (!isset($rules['byPrivilegeId'][$privilege])) {
            return null;
        } else {
            $rule = $rules['byPrivilegeId'][$privilege];
        }

        // check assertion first
        if ($rule['assert']) {
            $assertion = $rule['assert'];
            $assertionValue = $assertion->assert(
                $this,
                ($this->_isAllowedRole) ? $this->_isAllowedRole : $role,
                ($this->_isAllowedResource) ? $this->_isAllowedResource : $resource,
                $this->_isAllowedPrivilege
                );
        }

        if (null === $rule['assert'] || $assertionValue) {
            return $rule['type'];
        } else if (null !== $resource || null !== $role || null !== $privilege) {
            return null;
        } else if (self::TYPE_ALLOW === $rule['type']) {
            return self::TYPE_DENY;
        } else {
            return self::TYPE_ALLOW;
        }
    }
    protected function &_getRules($resource = null, $role = null, $create = false)
    {
        // create a reference to null
        $null = null;
        $nullRef =& $null;

        // follow $resource
        do {
            if (null === $resource) {
                $visitor =& $this->_rules['allResources'];
                break;
            }
            $resourceId = $resource->getResourceId();
            if (!isset($this->_rules['byResourceId'][$resourceId])) {
                if (!$create) {
                    return $nullRef;
                }
                $this->_rules['byResourceId'][$resourceId] = array();
            }
            $visitor =& $this->_rules['byResourceId'][$resourceId];
        } while (false);


        // follow $role
        if (null === $role) {
            if (!isset($visitor['allRoles'])) {
                if (!$create) {
                    return $nullRef;
                }
                $visitor['allRoles']['byPrivilegeId'] = array();
            }
            return $visitor['allRoles'];
        }
        $roleId = $role->getRoleId();
        if (!isset($visitor['byRoleId'][$roleId])) {
            if (!$create) {
                return $nullRef;
            }
            $visitor['byRoleId'][$roleId]['byPrivilegeId'] = array();
            $visitor['byRoleId'][$roleId]['allPrivileges'] = array('type' => null, 'assert' => null);
        }
        return $visitor['byRoleId'][$roleId];
    }
    public function getRegisteredRoles(){
        trigger_error('The method getRegisteredRoles() was deprecated as of '
                    . 'version 1.0, and may be removed. You\'re encouraged '
                    . 'to use getRoles() instead.');

        return $this->_getRoleRegistry()->getRoles();
    }
    public function getRoles(){return array_keys($this->_getRoleRegistry()->getRoles());}
    public function getResources(){return array_keys($this->_resources);}

}

class Zend_Acl_Role{
    protected $_roleId;
    public function __construct($roleId){$this->_roleId = (string) $roleId;}
    public function getRoleId(){return $this->_roleId;}
    public function __toString(){return $this->getRoleId();}
}

class Zend_Acl_Role_Registry{
    protected $_roles = array();
    public function add($role, $parents = null){
        $roleId = $role->getRoleId();
        if ($this->has($roleId)) {
            /**
             * @see Zend_Acl_Role_Registry_Exception
             */
            throw new Zend_Acl_Role_Registry_Exception("Role id '$roleId' already exists in the registry");
        }
        $roleParents = array();
        if (null !== $parents) {
            if (!is_array($parents)) {
                $parents = array($parents);
            }
            foreach ($parents as $parent) {
                try {
                    $roleParentId = $parent;
                    $roleParent = $this->get($roleParentId);
                } catch (Zend_Acl_Role_Registry_Exception $e) {
                    throw new Zend_Acl_Role_Registry_Exception("Parent Role id '$roleParentId' does not exist", 0, $e);
                }
                $roleParents[$roleParentId] = $roleParent;
                $this->_roles[$roleParentId]['children'][$roleId] = $role;
            }
        }
        $this->_roles[$roleId] = array(
            'instance' => $role,
            'parents'  => $roleParents,
            'children' => array()
            );
        return $this;
    }
    public function get($role)    {
        $roleId = (string) $role;
        if (!$this->has($role)) {
            throw new Zend_Acl_Role_Registry_Exception("Role '$roleId' not found");
        }
        return $this->_roles[$roleId]['instance'];
    }
    public function has($role){
        $roleId = (string) $role;
        return isset($this->_roles[$roleId]);
    }
    public function getParents($role){
        $roleId = $this->get($role)->getRoleId();
        return $this->_roles[$roleId]['parents'];
    }
    public function inherits($role, $inherit, $onlyParents = false){
        try {
            $roleId     = $this->get($role)->getRoleId();
            $inheritId = $this->get($inherit)->getRoleId();
        } catch (Zend_Acl_Role_Registry_Exception $e) {
            throw new Zend_Acl_Role_Registry_Exception($e->getMessage(), $e->getCode(), $e);
        }
        $inherits = isset($this->_roles[$roleId]['parents'][$inheritId]);
        if ($inherits || $onlyParents) {return $inherits;}
        foreach ($this->_roles[$roleId]['parents'] as $parentId => $parent) {
            if ($this->inherits($parentId, $inheritId)) {return true;}
        }
        return false;
    }
    public function remove($role){
        try {
            $roleId = $this->get($role)->getRoleId();
        } catch (Zend_Acl_Role_Registry_Exception $e) {
            throw new Zend_Acl_Role_Registry_Exception($e->getMessage(), $e->getCode(), $e);
        }

        foreach ($this->_roles[$roleId]['children'] as $childId => $child) {
            unset($this->_roles[$childId]['parents'][$roleId]);
        }
        foreach ($this->_roles[$roleId]['parents'] as $parentId => $parent) {
            unset($this->_roles[$parentId]['children'][$roleId]);
        }

        unset($this->_roles[$roleId]);

        return $this;
    }
    public function removeAll(){
        $this->_roles = array();

        return $this;
    }

    public function getRoles(){
        return $this->_roles;
    }

}
class Zend_Acl_Resource{
    protected $_resourceId;
    public function __construct($resourceId){$this->_resourceId = (string) $resourceId;}
    public function getResourceId(){return $this->_resourceId;}
    public function __toString(){return $this->getResourceId();}
}

