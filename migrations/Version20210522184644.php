<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522184644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, total INT NOT NULL, discount NUMERIC(10, 0) DEFAULT NULL, state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_issue (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, user_id_id INT NOT NULL, issue LONGTEXT NOT NULL, create_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_913357C3FCDAEAAA (order_id_id), INDEX IDX_913357C39D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_52EA1F09FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_log (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, order_id_id INT NOT NULL, state VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_CC6427A59D86650F (user_id_id), INDEX IDX_CC6427A5FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_shipping_detail (id INT AUTO_INCREMENT NOT NULL, order_id_id INT NOT NULL, country VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, zip VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_CE557980FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picked_box (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, order_id_id INT NOT NULL, box_id VARCHAR(255) NOT NULL, INDEX IDX_62DBA4EE9D86650F (user_id_id), INDEX IDX_62DBA4EEFCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipped_box (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, order_id_id INT NOT NULL, courier VARCHAR(255) NOT NULL, tracking VARCHAR(255) NOT NULL, label_image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_2E8276669D86650F (user_id_id), INDEX IDX_2E827666FCDAEAAA (order_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_issue ADD CONSTRAINT FK_913357C3FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_issue ADD CONSTRAINT FK_913357C39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_log ADD CONSTRAINT FK_CC6427A59D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE order_log ADD CONSTRAINT FK_CC6427A5FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_shipping_detail ADD CONSTRAINT FK_CE557980FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE picked_box ADD CONSTRAINT FK_62DBA4EE9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE picked_box ADD CONSTRAINT FK_62DBA4EEFCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE shipped_box ADD CONSTRAINT FK_2E8276669D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE shipped_box ADD CONSTRAINT FK_2E827666FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_issue DROP FOREIGN KEY FK_913357C3FCDAEAAA');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09FCDAEAAA');
        $this->addSql('ALTER TABLE order_log DROP FOREIGN KEY FK_CC6427A5FCDAEAAA');
        $this->addSql('ALTER TABLE order_shipping_detail DROP FOREIGN KEY FK_CE557980FCDAEAAA');
        $this->addSql('ALTER TABLE picked_box DROP FOREIGN KEY FK_62DBA4EEFCDAEAAA');
        $this->addSql('ALTER TABLE shipped_box DROP FOREIGN KEY FK_2E827666FCDAEAAA');
        $this->addSql('ALTER TABLE order_issue DROP FOREIGN KEY FK_913357C39D86650F');
        $this->addSql('ALTER TABLE order_log DROP FOREIGN KEY FK_CC6427A59D86650F');
        $this->addSql('ALTER TABLE picked_box DROP FOREIGN KEY FK_62DBA4EE9D86650F');
        $this->addSql('ALTER TABLE shipped_box DROP FOREIGN KEY FK_2E8276669D86650F');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_issue');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE order_log');
        $this->addSql('DROP TABLE order_shipping_detail');
        $this->addSql('DROP TABLE picked_box');
        $this->addSql('DROP TABLE shipped_box');
        $this->addSql('DROP TABLE `user`');
    }
}
