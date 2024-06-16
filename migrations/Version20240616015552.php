<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616015552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE toy_box (id INT AUTO_INCREMENT NOT NULL, pet_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_ECAD9AAB966F7FB6 (pet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toy_box_toy (id INT AUTO_INCREMENT NOT NULL, toy_box_id INT NOT NULL, quantity INT DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_F295714190A5CA98 (toy_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE toy_box ADD CONSTRAINT FK_ECAD9AAB966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id)');
        $this->addSql('ALTER TABLE toy_box_toy ADD CONSTRAINT FK_F295714190A5CA98 FOREIGN KEY (toy_box_id) REFERENCES toy_box (id)');
        $this->addSql('ALTER TABLE pet_toy DROP FOREIGN KEY FK_2E45B63B966F7FB6');
        $this->addSql('ALTER TABLE pet_toy DROP FOREIGN KEY FK_2E45B63BB524FDDC');
        $this->addSql('DROP TABLE pet_toy');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pet_toy (id INT AUTO_INCREMENT NOT NULL, pet_id INT NOT NULL, toy_id INT NOT NULL, quantity INT DEFAULT NULL, price NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_2E45B63B966F7FB6 (pet_id), INDEX IDX_2E45B63BB524FDDC (toy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pet_toy ADD CONSTRAINT FK_2E45B63B966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE pet_toy ADD CONSTRAINT FK_2E45B63BB524FDDC FOREIGN KEY (toy_id) REFERENCES toy (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE toy_box DROP FOREIGN KEY FK_ECAD9AAB966F7FB6');
        $this->addSql('ALTER TABLE toy_box_toy DROP FOREIGN KEY FK_F295714190A5CA98');
        $this->addSql('DROP TABLE toy_box');
        $this->addSql('DROP TABLE toy_box_toy');
    }
}
