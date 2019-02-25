<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprises
 *
 * @ORM\Table(name="entreprises")
 * @ORM\Entity
 */
class Entreprises
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="raison_sociale", type="string", length=255, nullable=false)
     */
    private $raisonSociale;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=false)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=30, nullable=false)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fax", type="string", length=30, nullable=true)
     */
    private $fax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="site_web", type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="forme_juridique", type="string", length=255, nullable=false)
     */
    private $formeJuridique;

    /**
     * @var int
     *
     * @ORM\Column(name="effectif", type="integer", nullable=false)
     */
    private $effectif;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surface_couverte", type="string", length=30, nullable=true)
     */
    private $surfaceCouverte;

    /**
     * @var string|null
     *
     * @ORM\Column(name="chiffre_affaire", type="string", length=30, nullable=true)
     */
    private $chiffreAffaire;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="export", type="boolean", nullable=true)
     */
    private $export;

    /**
     * @var string|null
     *
     * @ORM\Column(name="export_total", type="string", length=30, nullable=true)
     */
    private $exportTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="code_naf", type="string", length=30, nullable=false)
     */
    private $codeNaf;

    /**
     * @var string|null
     *
     * @ORM\Column(name="capital", type="string", length=30, nullable=true)
     */
    private $capital;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_dirigeant", type="string", length=255, nullable=false)
     */
    private $nomDirigeant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_dirigeant", type="string", length=255, nullable=true)
     */
    private $emailDirigeant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_res_com", type="string", length=255, nullable=true)
     */
    private $nomResCom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_res_com", type="string", length=255, nullable=true)
     */
    private $emailResCom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_res_achat", type="string", length=255, nullable=true)
     */
    private $nomResAchat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email_res_achat", type="string", length=255, nullable=true)
     */
    private $emailResAchat;

    /**
     * @var string
     *
     * @ORM\Column(name="savoir_faire", type="text", length=65535, nullable=false)
     */
    private $savoirFaire;

    /**
     * @var string|null
     *
     * @ORM\Column(name="equipements", type="text", length=65535, nullable=true)
     */
    private $equipements;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="qualite_agrement", type="boolean", nullable=true)
     */
    private $qualiteAgrement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualite", type="text", length=65535, nullable=true)
     */
    private $qualite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="manutention", type="text", length=65535, nullable=true)
     */
    private $manutention;

    /**
     * @var string|null
     *
     * @ORM\Column(name="secteurs_activite", type="text", length=65535, nullable=true)
     */
    private $secteursActivite;

    /**
     * @var string|null
     *
     * @ORM\Column(name="references_clients", type="text", length=65535, nullable=true)
     */
    private $referencesClients;

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_fort", type="text", length=65535, nullable=true)
     */
    private $pointFort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="environnement", type="string", length=255, nullable=true)
     */
    private $environnement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="savoir_faire_search", type="text", length=65535, nullable=true)
     */
    private $savoirFaireSearch;

    /**
     * @var string|null
     *
     * @ORM\Column(name="siret", type="string", length=30, nullable=true)
     */
    private $siret;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $icpe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="entreprise", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFormeJuridique(): ?string
    {
        return $this->formeJuridique;
    }

    public function setFormeJuridique(string $formeJuridique): self
    {
        $this->formeJuridique = $formeJuridique;

        return $this;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): self
    {
        $this->effectif = $effectif;

        return $this;
    }

    public function getSurfaceCouverte(): ?string
    {
        return $this->surfaceCouverte;
    }

    public function setSurfaceCouverte(?string $surfaceCouverte): self
    {
        $this->surfaceCouverte = $surfaceCouverte;

        return $this;
    }

    public function getChiffreAffaire(): ?string
    {
        return $this->chiffreAffaire;
    }

    public function setChiffreAffaire(?string $chiffreAffaire): self
    {
        $this->chiffreAffaire = $chiffreAffaire;

        return $this;
    }

    public function getExport(): ?bool
    {
        return $this->export;
    }

    public function setExport(?bool $export): self
    {
        $this->export = $export;

        return $this;
    }

    public function getExportTotal(): ?string
    {
        return $this->exportTotal;
    }

    public function setExportTotal(?string $exportTotal): self
    {
        $this->exportTotal = $exportTotal;

        return $this;
    }

    public function getCodeNaf(): ?string
    {
        return $this->codeNaf;
    }

    public function setCodeNaf(string $codeNaf): self
    {
        $this->codeNaf = $codeNaf;

        return $this;
    }

    public function getCapital(): ?string
    {
        return $this->capital;
    }

    public function setCapital(?string $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    public function getNomDirigeant(): ?string
    {
        return $this->nomDirigeant;
    }

    public function setNomDirigeant(string $nomDirigeant): self
    {
        $this->nomDirigeant = $nomDirigeant;

        return $this;
    }

    public function getEmailDirigeant(): ?string
    {
        return $this->emailDirigeant;
    }

    public function setEmailDirigeant(?string $emailDirigeant): self
    {
        $this->emailDirigeant = $emailDirigeant;

        return $this;
    }

    public function getNomResCom(): ?string
    {
        return $this->nomResCom;
    }

    public function setNomResCom(?string $nomResCom): self
    {
        $this->nomResCom = $nomResCom;

        return $this;
    }

    public function getEmailResCom(): ?string
    {
        return $this->emailResCom;
    }

    public function setEmailResCom(?string $emailResCom): self
    {
        $this->emailResCom = $emailResCom;

        return $this;
    }

    public function getNomResAchat(): ?string
    {
        return $this->nomResAchat;
    }

    public function setNomResAchat(?string $nomResAchat): self
    {
        $this->nomResAchat = $nomResAchat;

        return $this;
    }

    public function getEmailResAchat(): ?string
    {
        return $this->emailResAchat;
    }

    public function setEmailResAchat(?string $emailResAchat): self
    {
        $this->emailResAchat = $emailResAchat;

        return $this;
    }

    public function getSavoirFaire(): ?string
    {
        return $this->savoirFaire;
    }

    public function setSavoirFaire(string $savoirFaire): self
    {
        $this->savoirFaire = $savoirFaire;

        return $this;
    }

    public function getEquipements(): ?string
    {
        return $this->equipements;
    }

    public function setEquipements(?string $equipements): self
    {
        $this->equipements = $equipements;

        return $this;
    }

    public function getQualiteAgrement(): ?bool
    {
        return $this->qualiteAgrement;
    }

    public function setQualiteAgrement(?bool $qualiteAgrement): self
    {
        $this->qualiteAgrement = $qualiteAgrement;

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(?string $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getManutention(): ?string
    {
        return $this->manutention;
    }

    public function setManutention(?string $manutention): self
    {
        $this->manutention = $manutention;

        return $this;
    }

    public function getSecteursActivite(): ?string
    {
        return $this->secteursActivite;
    }

    public function setSecteursActivite(?string $secteursActivite): self
    {
        $this->secteursActivite = $secteursActivite;

        return $this;
    }

    public function getReferencesClients(): ?string
    {
        return $this->referencesClients;
    }

    public function setReferencesClients(?string $referencesClients): self
    {
        $this->referencesClients = $referencesClients;

        return $this;
    }

    public function getPointFort(): ?string
    {
        return $this->pointFort;
    }

    public function setPointFort(?string $pointFort): self
    {
        $this->pointFort = $pointFort;

        return $this;
    }

    public function getEnvironnement(): ?string
    {
        return $this->environnement;
    }

    public function setEnvironnement(?string $environnement): self
    {
        $this->environnement = $environnement;

        return $this;
    }

    public function getSavoirFaireSearch(): ?string
    {
        return $this->savoirFaireSearch;
    }

    public function setSavoirFaireSearch(?string $savoirFaireSearch): self
    {
        $this->savoirFaireSearch = $savoirFaireSearch;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getIcpe(): ?bool
    {
        return $this->icpe;
    }

    public function setIcpe(?bool $icpe): self
    {
        $this->icpe = $icpe;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newEntreprise = $user === null ? null : $this;
        if ($newEntreprise !== $user->getEntreprise()) {
            $user->setEntreprise($newEntreprise);
        }

        return $this;
    }

}
