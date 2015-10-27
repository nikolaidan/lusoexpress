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

    /** @var  BaseApplication $applicationInstance */
    private $applicationInstance;

    /** @var bool $showActionTemplate */
    private $showActionTemplate = true;

    /** @var bool $showControllerTemplate */
    private $showControllerTemplate = true;

    /**
     * @param BaseApplication $applicationInstance
     * @param Twig_Environment $templateEngine
     */
    public function __construct($applicationInstance, $templateEngine)
    {
        $this->templateEngine = $templateEngine;
        $this->applicationInstance = $applicationInstance;
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
            } else {
                return $this->controllerTemplate->render([]);
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
        if($this->showControllerTemplate) {
            $this->controllerTemplate = $this->templateEngine->loadTemplate($template);
        } else {
            unset($this->controllerTemplate);
        }
    }

    /**
     * @param string $template
     */
    public function setActionTemplate($template)
    {
        if($this->showActionTemplate) {
            $this->actionTemplate = $this->templateEngine->loadTemplate($template);
        } else {
            unset($this->actionTemplate);
        }
    }

    /**
     * @param bool|false $status
     */
    public function toggleActionTemplate($status = false)
    {
        $this->showActionTemplate = $status;
    }

    /**
     * @param bool|false $status
     */
    public function toggleControllerTemplate($status = false)
    {
        $this->showControllerTemplate = $status;
    }

    /**
     * @return BaseApplication
     */
    public function getApplication()
    {
        return $this->applicationInstance;
    }

}