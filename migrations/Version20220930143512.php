<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930143512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement ADD hebergement_country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9C455A19CA FOREIGN KEY (hebergement_country_id) REFERENCES countries (id)');
        $this->addSql('CREATE INDEX IDX_4852DD9C455A19CA ON hebergement (hebergement_country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9C455A19CA');
        $this->addSql('DROP INDEX IDX_4852DD9C455A19CA ON hebergement');
        $this->addSql('ALTER TABLE hebergement DROP hebergement_country_id');
    }
}
