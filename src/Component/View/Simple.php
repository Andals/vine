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
            if (is_array($value)) {
                return array_walk_recursive($value, 'htmlspecialchars');
            } else {
                $value = htmlspecialchars($value);
            }
        }
        $this->tplVarList[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function render($tplName, array $data=array())
    {
        // assin variable
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->assign($key, $value);
            }
        }
        
        // extract template variable list
        if (! empty($this->tplVarList)) {
            extract($this->tplVarList);
        }
        
        ob_start();
        require $this->getTplFile($tplName);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
    
}