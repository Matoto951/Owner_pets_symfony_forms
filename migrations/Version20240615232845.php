<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240615232845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pet_toy (pet_id INT NOT NULL, toy_id INT NOT NULL, INDEX IDX_2E45B63B966F7FB6 (pet_id), INDEX IDX_2E45B63BB524FDDC (toy_id), PRIMARY KEY(pet_id, toy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE toy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pet_toy ADD CONSTRAINT FK_2E45B63B966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pet_toy ADD CONSTRAINT FK_2E45B63BB524FDDC FOREIGN KEY (toy_id) REFERENCES toy (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet_toy DROP FOREIGN KEY FK_2E45B63B966F7FB6');
        $this->addSql('ALTER TABLE pet_toy DROP FOREIGN KEY FK_2E45B63BB524FDDC');
        $this->addSql('DROP TABLE pet_toy');
        $this->addSql('DROP TABLE toy');
    }
}
