<?php

namespace kennysLabs\CommonLibrary\ApplicationManager;

abstract class BaseController {

    /** @var  string $templatePath */
    protected $templatePath;

    /** @var  \Twig_Template  $controllerTemplate */
    protected $controllerTemplate;

    /** @var  \Twig_Template  $actionTemplate */
    protected $actionTemplate;

    /** @var  \Twig_Environment $actionTemplate */
    protected $templateEngine;

    /**
     * @param Twig_Environment $templateEngine
     */
    public function __construct($templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    /**
     * Render the current request action
     */
    public function render()
    {
        if(isset($this->controllerTemplate))
        {
            if(isset($this->actionTemplate)) {
                return $this->controllerTemplate->render(['actionTemplate' => $this->actionTemplate->render([])]);
            }
        } else {
            if(isset($this->actionTemplate)) {
                return $this->actionTemplate->render([]);
            }
        }
    }

    /**
     * @param string $template
     */
    public function setControllerTemplate($template)
    {
        $this->controllerTemplate = $this->templateEngine->loadTemplate($template);
    }

    /**
     * @param string $template
     */
    public function setActionTemplate($template)
    {
        $this->actionTemplate = $this->templateEngine->loadTemplate($template);
    }

}