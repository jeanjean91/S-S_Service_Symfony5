<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200318044230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL, ADD civilite VARCHAR(255) NOT NULL, ADD secu_social VARCHAR(255) DEFAULT NULL, ADD tel VARCHAR(255) DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_60A26480E7927C74 ON prestataire');
        $this->addSql('ALTER TABLE prestataire DROP email, DROP roles, DROP password, DROP user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE prestataire ADD email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD roles JSON NOT NULL, ADD password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD user VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_60A26480E7927C74 ON prestataire (email)');
        $this->addSql('ALTER TABLE user DROP nom, DROP prenom, DROP civilite, DROP secu_social, DROP tel, DROP adresse, DROP image');
    }
}
