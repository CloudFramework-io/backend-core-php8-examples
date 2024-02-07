<?php
/**
 * Basic structure for a CloudFramework API
 * last-update 2024-01
 * Author: CloudFramework.io.
 * Version: 1.0.0
 */
 */
class API extends RESTful
{
    var $end_point= '';
    function main()
    {
        //You can restrict methods in main level
        if(!$this->checkMethod('GET,POST,PUT,DELETE')) return;

        //Call internal ENDPOINT_$end_point
        $this->end_point = str_replace('-','_',$this->params[1] ?? 'default');
        if(!$this->useFunction('ENDPOINT_'.$this->end_point)) {
            return($this->setErrorFromCodelib('params-error',"/{$this->service}/{$this->end_point} is not implemented"));
        }
    }

    /**
     * Endpoint to add a default feature. We suggest to use this endpoint to explain how to use other endpoints
     */
    public function ENDPOINT_default()
    {
        // return Data in json format by default
        $this->addReturnData([
            "end-point default [current]"=>"use /{$this->service}/default"
            ,"end-point hello"=>"use /{$this->service}/hello"
            ,"Current parameters"=>$this->params
            ,"Current formParameters"=>$this->formParams]);
    }

    /**
     * Endpoint to show Hello World message
     */
    public function ENDPOINT_hello()
    {
        //You can restrict methods in endpoint level
        if(!$this->checkMethod('GET,POST,PUT,DELETE')) return;

        // return Data in json format by default
        $this->addReturnData('Advanced hello World');
    }
}