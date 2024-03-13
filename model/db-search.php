<?php

global $PDO;
require_once 'model/db-connection.php';

function search() {
    global $PDO;    
    if (isset($_POST['titre']) && $_POST['titre']!="") {
        if (isset($_POST['auteur']) && $_POST['auteur']!="") {
            if (isset($_POST['annee']) && $_POST['annee']!="") {
                if (isset($_POST['genre']) && $_POST['genre']!="") {
                    $titre = $_POST['titre'];
                    $auteur = $_POST['auteur'];
                    $annee = $_POST['annee'];
                    $genre = $_POST['genre'];
                    $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND auteur LIKE :auteur AND annee LIKE :annee AND genre LIKE :genre");
                    $stmt->bindValue(':titre', "$titre");
                    $stmt->bindValue(':auteur', "$auteur");
                    $stmt->bindValue(':annee', "$annee");
                    $stmt->bindValue(':genre', "$genre");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;
                } else {
                    $titre = $_POST['titre'];
                    $auteur = $_POST['auteur'];
                    $annee = $_POST['annee'];
                    $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND auteur LIKE :auteur AND annee LIKE :annee");
                    $stmt->bindValue(':titre', "$titre");
                    $stmt->bindValue(':auteur', "$auteur");
                    $stmt->bindValue(':annee', "$annee");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    return $result;           
                }          
            } elseif (isset($_POST['genre']) && $_POST['genre']!="") {
                $titre = $_POST['titre'];
                $auteur = $_POST['auteur'];
                $genre = $_POST['genre'];
                $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND auteur LIKE :auteur AND genre LIKE :genre");
                $stmt->bindValue(':titre', "$titre");
                $stmt->bindValue(':auteur', "$auteur");
                $stmt->bindValue(':genre', "$genre");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;           
            } else {
                $titre = $_POST['titre'];
                $auteur = $_POST['auteur'];
                $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND auteur LIKE :auteur");
                $stmt->bindValue(':titre', "$titre");
                $stmt->bindValue(':auteur', "$auteur");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;           
            }         
        } elseif (isset($_POST['annee']) && $_POST['annee']!="") {
            if (isset($_POST['genre']) && $_POST['genre']!="") {
                $titre = $_POST['titre'];
                $annee = $_POST['annee'];
                $genre = $_POST['genre'];
                $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND annee LIKE :annee AND genre LIKE :genre");
                $stmt->bindValue(':titre', "$titre");
                $stmt->bindValue(':annee', "$annee");
                $stmt->bindValue(':genre', "$genre");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;           
            } else {
                $titre = $_POST['titre'];
                $annee = $_POST['annee'];
                $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND annee LIKE :annee");
                $stmt->bindValue(':titre', "$titre");
                $stmt->bindValue(':annee', "$annee");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;           
            }         
        } elseif (isset($_POST['genre']) && $_POST['genre']!="") {
            $titre = $_POST['titre'];
            $genre = $_POST['genre'];
            $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre AND genre LIKE :genre");
            $stmt->bindValue(':titre', "$titre");
            $stmt->bindValue(':genre', "$genre");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $titre = $_POST['titre'];
            $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE titre LIKE :titre");
            $stmt->bindValue(':titre', "$titre");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    } elseif (isset($_POST['auteur']) && $_POST['auteur']!="") {
        if (isset($_POST['annee']) && $_POST['annee']!="") {
            if (isset($_POST['genre']) && $_POST['genre']!="") {
                $auteur = $_POST['auteur'];
                $annee = $_POST['annee'];
                $genre = $_POST['genre'];
                $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE auteur LIKE :auteur AND annee LIKE :annee AND genre LIKE :genre");
                $stmt->bindValue(':auteur', "$auteur");
                $stmt->bindValue(':annee', "$annee");
                $stmt->bindValue(':genre', "$genre");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;           
            } else {
                $auteur = $_POST['auteur'];
                $annee = $_POST['annee'];
                $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE auteur LIKE :auteur AND annee LIKE :annee");
                $stmt->bindValue(':auteur', "$auteur");
                $stmt->bindValue(':annee', "$annee");
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;           
            }           
        } elseif (isset($_POST['genre']) && $_POST['genre']!="") {
            $auteur = $_POST['auteur'];
            $genre = $_POST['genre'];
            $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE auteur LIKE :auteur AND genre LIKE :genre");
            $stmt->bindValue(':auteur', "$auteur");
            $stmt->bindValue(':genre', "$genre");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $auteur = $_POST['auteur'];
            $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE auteur LIKE :auteur");
            $stmt->bindValue(':auteur', "$auteur");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }       
    } elseif (isset($_POST['annee']) && $_POST['annee']!="") {
        if (isset($_POST['genre']) && $_POST['genre']!="") {
            $annee = $_POST['annee'];
            $genre = $_POST['genre'];
            $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE annee LIKE :annee AND genre LIKE :genre");
            $stmt->bindValue(':annee', "$annee");
            $stmt->bindValue(':genre', "$genre");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;           
        } else {
            $annee = $_POST['annee'];
            $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE annee LIKE :annee");
            $stmt->bindValue(':annee', "$annee");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;          
        }           
    } elseif (isset($_POST['genre']) && $_POST['genre']!="") {
        $genre = $_POST['genre'];
        $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music WHERE genre LIKE :genre");
        $stmt->bindValue(':genre', "$genre");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } else {
        $stmt = $PDO->prepare("SELECT titre, auteur, annee, genre FROM music");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }    
}