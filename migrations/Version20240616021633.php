<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240616021633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE toy_box_toy ADD toy_id INT NOT NULL');
        $this->addSql('ALTER TABLE toy_box_toy ADD CONSTRAINT FK_F2957141B524FDDC FOREIGN KEY (toy_id) REFERENCES toy (id)');
        $this->addSql('CREATE INDEX IDX_F2957141B524FDDC ON toy_box_toy (toy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE toy_box_toy DROP FOREIGN KEY FK_F2957141B524FDDC');
        $this->addSql('DROP INDEX IDX_F2957141B524FDDC ON toy_box_toy');
        $this->addSql('ALTER TABLE toy_box_toy DROP toy_id');
    }
}
