<?php
/**
 * User $this->core->user object to authentication for PLATFORM-USERS
 */
class API extends RESTful
{
    var $end_point= '';
    function main()
    {
        //You can restrict methods in main level
        if(!$this->checkMethod('GET,POST,PUT,DELETE')) return;

        //region VERIFY header X-DS-TOKEN to validate as PLATFORM USER token
        if($token = $this->getHeader('X-DS-TOKEN')) {
            if(!$this->core->user->checkERPToken($token,'test'))
                return $this->setErrorFromCodelib($this->core->user->errorCode,$this->core->user->errorMsg);
        }
        //endregion

        //Call internal ENDPOINT_$end_point
        $this->end_point = str_replace('-','_',($this->params[1] ?? 'default'));
        if(!$this->useFunction('ENDPOINT_'.str_replace('-','_',$this->end_point))) {
            return($this->setErrorFromCodelib('params-error',"/{$this->service}/{$this->end_point} is not implemented"));
        }
    }

    /**
     * Endpoint to add a default feature. We suggest to use this endpoint to explain
     * how to use other endpoints
     */
    public function ENDPOINT_signin()
    {

        //region READ $user, $password, $platform
        if(!$user = $this->checkMandatoryFormParam('user')) return;
        if(!$password = $this->checkMandatoryFormParam('password')) return;
        if(!$platform = $this->checkMandatoryFormParam('platform')) return;
        if(!$key = $this->checkMandatoryFormParam('key')) return;
        //endregion

        if(!$this->core->user->loginCloudPlatform($user,$password,$platform,$key)) {
            return $this->setErrorFromCodelib($this->core->user->errorCode,$this->core->user->errorMsg);
        }
        $this->ok = 201;
        $this->addReturnData(['token'=>$this->core->user->token,'expiration'=>$this->core->user->tokenExpiration]);
    }


    /**
     * Endpoint to check a token
     */
    public function ENDPOINT_check()
    {
        //region VERIFY header X-DS-TOKEN to validate as PLATFORM USER token
        if(!$key = $this->getHeader('X-EXTRA-INFO')) return $this->setErrorFromCodelib('params-error','Missing header X-EXTRA-INFO with the Integration Key Value');
        if(!$token = $this->getHeader('X-DS-TOKEN')) return $this->setErrorFromCodelib('params-error','Missing header X-DS-TOKEN with the token');
        if(!$this->core->user->checkPlatformToken($token,$key,true))
            return $this->setErrorFromCodelib($this->core->user->errorCode,$this->core->user->errorMsg);
        //endregion
        $this->addReturnData(['User'=>$this->core->user->data]);
    }

}