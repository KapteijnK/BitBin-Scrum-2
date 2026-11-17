<?php

require_once "database/connection.php";

function savepost(PDO $conn, string $titel, string $inhoud, int $categorie_id, string $link): ?string
{
    try {
        $query = $conn->prepare("INSERT INTO posts (titel, inhoud, categorie_id, link) VALUES (:titel, :inhoud, :categorie_id, :link)");
        $query->bindParam(':titel', $titel, PDO::PARAM_STR, 255);
        $query->bindParam(':inhoud', $inhoud, PDO::PARAM_LOB);
        $query->bindParam(':categorie_id', $categorie_id, PDO::PARAM_INT, 3);
        $query->bindParam(':link', $link, PDO::PARAM_STR, 255);
        $query->execute();
        return 'Succesfully added to database';
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
