<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625125345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anounce (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, desription LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, cover_image VARCHAR(255) NOT NULL, rooms INT NOT NULL, is_available TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, intro VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, anounce_id INT DEFAULT NULL, mail VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, author VARCHAR(255) NOT NULL, INDEX IDX_9474526C87016831 (anounce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, anounce_id INT DEFAULT NULL, image_url VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_C53D045F87016831 (anounce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C87016831 FOREIGN KEY (anounce_id) REFERENCES anounce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F87016831 FOREIGN KEY (anounce_id) REFERENCES anounce (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C87016831');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F87016831');
        $this->addSql('DROP TABLE anounce');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE image');
    }
}
