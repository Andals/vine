<?php

namespace Vine\Component\View;

class Simple extends Base
{

    /**
     * template variable list
     * @author tabalt
     * @var array
     */
    private $tplVarList = array();

    /**
     * {@inheritdoc}
     */
    public function assign($key, $value, $secureFilter=true)
    {
        if (! preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*/i', $key)) {
            throw new \Exception('template variable ' . $key . ' name error');
        }
        if ($secureFilter) {
            $value = htmlspecialchars($value);
        }
        $this->tplVarList[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function render($tplName, $data=array())
    {
        // assin variable
        foreach ($data as $key => $value) {
        	$this->assign($key, $value);
        }
        
        // extract template variable list
        if (! empty($this->tplVarList)) {
            extract($this->tplVarList);
        }
        
        $tplFile = $this->getTplFile($tplName);
        
        ob_start();
        require $tplFile;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}