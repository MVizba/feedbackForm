<?php

class ReadUnread
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function toggleRead($feedbackId)
    {
        $stmt = $this->pdo->prepare("SELECT is_read FROM feedback WHERE id = :id");
        $stmt->execute(['id' => $feedbackId]);
        $currentStatus = $stmt->fetchColumn();

        $newStatus = $currentStatus ? 0 : 1;
        $sql = "UPDATE feedback SET is_read = :newStatus WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['newStatus' => $newStatus, 'id' => $feedbackId]);
    }
}

