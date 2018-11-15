<?php

  class ville
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $INSEE;
    private $libVil;
    private $CP;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE


    public function ville($liVil,$CP,$INSEE="")
    {
      $this->INSEE = $INSEE;
      $this->libVil = $liVil;
      $this->CP = $CP;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_INSEE()
    {
      return $this->INSEE;
    }
    public function get_libVil()
    {
      return $this->libVil;
    }
    public function get_CP()
    {
      return $this->CP;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_libVil($libVil)
    {
      $this->libVil = $libVil;
    }
    public function set_CP($CP)
    {
      $this->CP = $CP;
    }
    public function searchInfo($conn,$INSEE)
    {
      $INSEE = $conn -> quote($INSEE);
      $SQL_search = "SELECT * FROM ville WHERE INSEE = $INSEE";
      $req_sql = $conn -> query($SQL_search);
      if ($req_sql == FALSE)
      {
        return false;
      }
      else
      {
        $res_SQL = $req_sql -> fetch();
        $this->CP = $res_SQL['CP'];
        $this->libVil = $res_SQL['libVill'];
        return TRUE;
      }
    }
    public function searchIfExist($conn)
    {
      $cp = $this->CP;
      $cp = $conn -> quote($cp);
      $lib = $this->libVil;
      $lib = $conn -> quote($lib);
      $sql_search = "SELECT * FROM ville
                     WHERE CP = $cp
                     AND libVill LIKE $lib";
      $req_SQL = $conn->query($sql_search);
      if ($req_SQL !== FALSE)
      {
        $res_Req = $req_SQL -> fetch();
        $this->INSEE = $res_Req['INSEE'];
        return TRUE;
      }else {
        return FALSE;
      }
    }

  }

?>
