<?php
  class Controller
  {
    private $conn; //chaine de connexion à la BDD

    public function Controller($conn)
    {
      $this->conn = $conn;
    }
    /**
    GETTER
    **/
    public function get_conn()
    {
      return $this->conn;
    }
    /**
    SETTER
    **/
    public function set_conn($conn)
    {
      $this->conn = $conn;
    }
    /**
    Fonctions
    **/
    /***************************************************************************
    Execute une requete SQL en SELECT *
    Entrée :
      Nom de la table choisi
    Sortie :
      Resultats de la requete.
    ***************************************************************************/
    public function selectAllTable($Var_nametable)
    {
      $sql_SELECTTABLE = "SELECT * FROM $Var_nametable";
      $conn = $this->get_conn();
      $req_sql = $conn->query($sql_SELECTTABLE);
      $res_sql = $req_sql -> fetchall(PDO::FETCH_ASSOC);
      return $res_sql;
    }
    public function insertBDD($Var_nametable,$tab_value)
    {
      $sql_INSERTTABLE = "INSERT INTO $Var_nametable";

      $i = 0;
      foreach ($tab_value as $var_tabLine)
      {
        if ($i == 0)
        {
          $sql_INSERTTABLE = $sql_INSERTTABLE." VALUES('".$var_tabLine."'";
          $i = 1;
        }
        else
        {
          $sql_INSERTTABLE = $sql_INSERTTABLE.",'".$var_tabLine."'";
        }
      }
      $sql_INSERTTABLE = $sql_INSERTTABLE.')';
      $conn = $this->get_conn();
      $req_sql = $conn->query($sql_INSERTTABLE);
    }
  }
 ?>
