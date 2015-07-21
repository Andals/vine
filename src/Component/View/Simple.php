<?php

namespace Vine\Component\View;

class Simple extends Base
{

    /**
     * view variable list
     * @author tabalt
     * @var array
     */
    private $viewVariableList = array();
    
    /**
     * tmp value list, avoid variable overrides
     * @var string
     */
    private $tmpValueList = array();

    /**
     * {@inheritdoc}
     */
    public function assign($key, $value, $secureFilter = true)
    {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*/i', $key)) {
            throw new \Exception('view variable ' . $key . ' name error');
        }
        if ($secureFilter) {
            if (is_array($value)) {
                array_walk_recursive($value, function (&$item, $key) {
                    if (is_string($item)) {
                        $item = htmlspecialchars($item);
                    }
                });
            } else if (is_string($value)) {
                $value = htmlspecialchars($value);
            }
        }
        $this->viewVariableList[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function render($viewFile, $withViewSuffix = false, array $data = array())
    {
        // set view file into tmp value list, avoid variable overrides
        $this->tmpValueList['view_file'] = $this->getViewFileWithViewRoot($viewFile, $withViewSuffix);
        
        // assin variable
        foreach ($data as $key => $value) {
            $this->assign($key, $value);
        }
        
        // extract view variable list
        if (!empty($this->viewVariableList)) {
            extract($this->viewVariableList);
        }
        
        ob_start();
        require $this->tmpValueList['view_file'];
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
    }
}