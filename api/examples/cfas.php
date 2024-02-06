<?php
/**
 * Basic structure for a CloudFramework API
 * last-update 2021-12
 * Author: CloudFramework.io
 */
class API extends RESTful
{
        var $end_point= '';
        var $user=null;
        var $company=null;

        function main()
        {
            //You can restrict methods in main level
            $this->sendCorsHeaders('GET');
            if(!$this->checkMethod('GET')) return;

            //Read user paramater
            $this->user = $this->params[1] ?? null;
            $this->company = $this->params[2] ?? null;
            //Return it in the response
            $this->updateReturnResponse(['user'=>$this->user,'company'=> $this->company]);

            //Call internal ENDPOINT_$end_point
            $this->end_point = str_replace('-','_',$this->params[3] ?? 'default');
            if(!$this->useFunction('ENDPOINT_'.$this->end_point)) {
                return($this->setErrorFromCodelib('params-error',"/{$this->service}/{$this->user}/{$this->company}{$this->end_point} is not implemented"));
            }
        }

        /**
         * Endpoint to add a default feature. We suggest to use this endpoint to explain how to use other endpoints
         */
        public function ENDPOINT_default()
        {
            // return Data in json format by default
            $this->addReturnData([
                "end-point default [current]"=>"use /{$this->service}/:platform/:iduser/default"
                ,"end-point cfa"=>"use /{$this->service}/:platform/:iduser/default"
                ,"Current parameters"=>$this->params
                ,"Current formParameters"=>$this->formParams]);
        }

        /**
         * Endpoint to show Hello World message
         */
        public function ENDPOINT_cfa()
        {
            /** @var CFA $cfa */
            $cfa = $this->core->loadClass('CFA');
            $cfa->rowLabels('row_title,row_progress');
            $cfa->addComponentInLabel('row_title')
                ->header()
                ->title('CFA Ejemplo')
                ->subtitle('con subtitular');

            $cfa->addComponentInLabel('row_title')
              ->header()
              ->title('CFA Ejemplo')
              ->subtitle('con subtitular');
            $this->addReturnData($cfa->getData());

          $cfa->addComponentInLabel('row_progress')
            ->progressChart()
            ->title('Progress Chart')
            ->max(100)
            ->value(70)
            ->class('bg-success');
          $this->addReturnData($cfa->getData());
        }
}