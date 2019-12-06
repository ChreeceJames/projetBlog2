<?php

require "model/chapitreModel.php";
// require "redaction.php";

class Chapitre {
  private $_id;
  private $_titre;
  private $_contenu;
  private $_date_time_publication;
  private $_date_time_edition;
  private $_slug;


// new Chapitre(["id"=>22]);
// new Chapitre(["slug"=>"un-chapitre-extraordinaire"]);
// new Chapitre(["list"=>["start"=>15, "qty"=>5]]);
/**
 * make a new iteration of chapitre
 * @param Array $args un tableau contenant soit id, soit slug, soit list
 */
  public function __construct($args){
      global $safeData;
//      if ($safeData->post != null) {
//        if ($safeData->post['titre'] != null)$this->updateOrSave();
//      }
//      else {
        //on récupère les données de la base
        $data = new ChapitreModel($args);

        //on génère les données de la classe et la vue en fonction des arguments
        if (isset($args["list"])) $vue = $this->listOfChapter($args, $data->_contenu);
        else $vue = $this->singleChapter($data);

        //on enregistre la vue générée
        $this->_contenu = $vue->html;
//      }
  }


/* ----fonctions ajoutées---- */
  private function updateOrSave(){
    //on a des données en post qui concernent le chapitre (puisque c'estle titre),il faut définir si on enregistre ou met à jour le chapitre
  }

/**
 * génère la vue en fonction des données du model
 * @param  Array $data données issues de la base de donnée
 * @return View       
 */
  public function singleChapter($data){

    //on hydrate la classe chapitre
    foreach ($data as $key => $value) {
      $this->$key = $value;
    }

    if ($this->_date_time_edition != null) $this->_date_time_edition = "<em>article modifié le $this->_date_time_edition</em>";
    else $this->_date_time_edition = "";

    // on retourne la vue claculée en fonction des données
    return new View(
     
      [
        "{{ title }}"                   => $this->_titre,
        "{{ contenu }}"                 => $this->_contenu,
        "{{ date_time_publication }}" => $this->_date_time_publication,
        "{{ date_time_edition }}"     => $this->_date_time_edition,
        "{{ slug }}"                  => $this->_slug,
        "{{ id }}"                  => $this->_id,
      ],
      "fullChapitre"
    );
  }


/**
 * génère la vue en fonction des données du model et des spécifications données lors de l'instantiation de la classe.
 * @param  Array $data   données issues de la base de donnée
 * @param  Array $args   spécifications données lors de l'instantiation de la classe. Contient un tableau list avec les valeurs start et qty
 * @return View  
 */
  private function listOfChapter($args, $data){
    //on "hydrate" la classe chapitre
    extract($args["list"]);
    if($start == 0) $this->_titre =  "liste des derniers chapitres";
    else            $this->_titre = "liste des chapitres : page ".$start/$qty." sur ".ceil(count($data)/$qty);

    // on retourne la vue claculée en fonction des données
    return new View(
      $data,
      "resumeChapitre"
    );
  }



// Liste des getters
  
  public function id()
  {
    return $this->_id;
  }
  
  public function title()
  {
    return $this->_titre;
  }
  
  public function content()
  {
    return $this->_contenu;
  }
  
  public function timePublication()
  {
    return $this->_date_time_publication;
  }
  
  public function timeEdition()
  {
    return $this->_date_time_edition;
  }
  public function slug()
  { return $this->_slug;
  }
  
  // Liste des setters
  
  public function setId($id)
  {
   
    $id = (int) $id;
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  
  public function setTitre($_titre)
  {
    // On vérifie qu'il s'agit bien d'une chaîne de caractères.
    if (is_string($_titre))
    {
      $this->_titre = $_titre;
    }
  }
  
  public function setContenu ($_contenu)
 {
 	if (preg_match(['#a-zA-Z0-9#'], $_contenu))
 	{
 		$this->_contenu = $_contenu;
 	}
 }
  
  public function setDateTimePublication ($_date_time_publication)
  {
   if(preg_match('#[0-2][0-3]:[0-5][0-9]:[0-5][0-9]#', $_date_time_publication))
	{
 	$this->_date_time_publication = $_date_time_publication;
	}
  }
  
  public function setDateTimeEdition($_date_time_edition)
  {
   if(preg_match('#[0-2][0-3]:[0-5][0-9]:[0-5][0-9]#', $_date_time_edition))
	{
 	$this->_date_time_edition = $_date_time_edition;
	}
  }
  public function setSlug($_slug)
  {
    if (is_string($_slug))
    {
      $this->_slug = $_slug;
    }
  }
  }