<?php
class user_agent_string {
	protected $data_file='';
	public $data=[];
	protected $save_on_update=true;
	public $debug=false;
	protected $empty_agent=['agent_type'=>''];

	function __construct($save_on_update=true){
		$this->save_on_update=$save_on_update;
		$dir=__DIR__.'/store/';
		@mkdir($dir);
		$this->data_file=$dir.'ua-data';
		$data=file_load($this->data_file,true);
		$this->data=$data ?: [];
	}

	public function get($user_agent){
		$data=$this->data[$user_agent];
		return $this->check_unknown($data,$user_agent);
	}

	public function has($user_agent){
		return !empty($this->data[$user_agent]);
	}

	public function get_agent($user_agent){
		if (empty($user_agent)){
			return [];
		}
		if ($this->has($user_agent)){
			return $this->get($user_agent);
		}
		$data=$this->get_agent_url($user_agent);
		if (!empty($data)){
			$this->data[$user_agent]=$data;
			$this->data_updated();
		}
		return $this->check_unknown($data,$user_agent);
	}

	protected function get_agent_url($user_agent){
		if ($this->debug){
			echo 'Getting agent: '.$user_agent.PHP_EOL;
		}
		$json=file_get_contents('http://www.useragentstring.com/?uas='.urlencode($user_agent).'&getJSON=all');
		if (empty($json)){
			return [];
		}
		$data=json_decode($json,true);
		if (empty($data)){
			return [];
		}
		return array_pull($data,['agent_type','agent_name']);
	}

	protected function check_unknown($data,$user_agent){
		if ($data['agent_type']=='unknown' and in_string(['bot','crawler'],$user_agent)){
			$data['agent_type']='Bot/Crawler';
		}
		return $data;
	}

	protected function data_updated(){
		if (!$this->save_on_update){
			return;
		}
		file_save($this->data_file,$this->data,true);
	}
}
