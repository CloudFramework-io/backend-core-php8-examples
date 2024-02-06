<?php
class API extends RESTful
{
    function main()
    {
      if(!($this->core->security->readERPSecretVars('secret-examples','academy' )))
          return($this->setErrorFromCodelib('secrets-error',$this->core->security->errorMsg));

      if(!$secret = $this->core->security->getSecretVar('secret')) {
          if($this->core->security->error)
              return($this->setErrorFromCodelib('secrets-error',$this->core->security->errorMsg));
          else
              return $this->setErrorFromCodelib('conflict','There is no content');
      }
      return $this->addReturnData(['secret'=>$secret]);

    }
}