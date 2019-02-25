<?php

namespace App\Service;

use Twig\Environment;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationSearch {
    
    private $limit = 10;
    private $currentPage = 1;
    private $twig;
    private $route;
    private $templatePath;
    private $export;
    private $qualite;
    private $search;
    private $repo;
    

    public function __construct(Environment $twig, RequestStack $request, $templatePath) {
        $this->route        = $request->getCurrentRequest()->attributes->get('_route');
        $this->twig         = $twig;
        $this->templatePath = $templatePath;
    }
    // render twig
    public function display() {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }
    // get the number of results
    public function nbResults() {
        $total = $this->getPages()[1];
    
        return $total;
    }
    // get the number of pages
    public function getPages() {     
        // if export and qualite are checked ...
        if ($this->export != null && $this->qualite != null) {
            // number of results
            $total = count($this->repo->findAllSearch($this->search,1 ,1));
            // number of pages
            $nbPages = ceil($total / $this->limit);
            
        } elseif ($this->export != null) {
            $total = count($this->repo->findAllSearch($this->search,1 ,''));
            $nbPages = ceil($total / $this->limit);
        } elseif ($this->qualite != null) {
            $total = count($this->repo->findAllSearch($this->search,'' ,1));
            $nbPages = ceil($total / $this->limit);
        }
        else {
            $total = count($this->repo->findAllSearch($this->search,'' ,''));
            $nbPages = ceil($total / $this->limit);
        }
        $pages = array($nbPages, $total);
        
        return $pages;
    }
    // get results from database
    public function getData() {
        $offset = $this->currentPage * $this->limit - $this->limit;
        
        if($this->export != null && $this->qualite != null) {
            $data = $this->repo->findAllSearch($this->search,1 ,1, $this->limit, $offset);
            
        } elseif($this->export != null) {
            $data = $this->repo->findAllSearch($this->search,1 ,'', $this->limit, $offset);
        } elseif($this->qualite != null) {
            $data = $this->repo->findAllSearch($this->search,'' ,1 , $this->limit, $offset);
        }
        else {
            $data = $this->repo->findAllSearch($this->search,'' ,'' , $this->limit, $offset);
        }
        
        return $data;
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
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
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
     * Set the value of export
     *
     * @return  self
     */ 
    public function setExport($export)
    {
        $this->export = $export;

        return $this;
    }

    /**
     * Set the value of qualite
     *
     * @return  self
     */ 
    public function setQualite($qualite)
    {
        $this->qualite = $qualite;

        return $this;
    }

    /**
     * Set the value of search
     *
     * @return  self
     */ 
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Set the value of repo
     *
     * @return  self
     */ 
    public function setRepo($repo)
    {
        $this->repo = $repo;

        return $this;
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


    /**
     * Get the value of export
     */ 
    public function getExport()
    {
        return $this->export;
    }


    /**
     * Get the value of qualite
     */ 
    public function getQualite()
    {
        return $this->qualite;
    }

    /**
     * Get the value of search
     */ 
    public function getSearch()
    {
        return $this->search;
    }


    /**
     * Get the value of repo
     */ 
    public function getRepo()
    {
        return $this->repo;
    }
}