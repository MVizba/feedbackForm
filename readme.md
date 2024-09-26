


```
CREATE DATABASE `client_feedback` 

CREATE TABLE `feedback` (
`id` int NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`email` varchar(255) NOT NULL,
`message` text NOT NULL,
`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
`is_read` tinyint(1) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```


