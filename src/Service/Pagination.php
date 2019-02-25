<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class Pagination {
    
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;

    public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath) {
        $this->route        = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager      = $manager;
        $this->twig         = $twig;
        $this->templatePath = $templatePath;
    }


    public function display() {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }

    public function getPages() {
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        $pages = ceil($total / $this->limit);

        return $pages;
    }
    
    public function getData() {
        $offset = $this->currentPage * $this->limit - $this->limit;
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([], [], $this->limit, $offset);

        return $data;
    }
    
    /**
     * Set the value of entityClass
     *
     * @return  self
     */ 
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
        
        return $this;
    }
    
    /**
     * Set the value of limit
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;
        
        return $this;
    }

    /**
     * Set the value of currentPage
     *
     * @return  self
     */ 
    public function setPage($currentPage)
    {
        $this->currentPage = $currentPage;
        
        return $this;
    }

    /**
     * Set the value of route
     *
     * @return  self
     */ 
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Set the value of templatePath
     *
     * @return  self
     */ 
    public function setTemplatePath($templatePath)
    {
        $this->templatePath = $templatePath;

        return $this;
    }
     
    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get the value of currentPage
     */ 
    public function getPage()
    {
        return $this->currentPage;
    }
    
    /**
     * Get the value of route
     */ 
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Get the value of templatePath
     */ 
    public function getTemplatePath()
    {
        return $this->templatePath;
    }

}