<?php
class DeleteFeedback {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function delete($feedbackId) {
        $sql = "DELETE FROM feedback WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $feedbackId]);
    }
}
