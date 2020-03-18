<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311210043 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorys (id INT AUTO_INCREMENT NOT NULL, categorys_id INT DEFAULT NULL, nom_cat VARCHAR(255) NOT NULL, INDEX IDX_F76B7134A96778EC (categorys_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorys ADD CONSTRAINT FK_F76B7134A96778EC FOREIGN KEY (categorys_id) REFERENCES categorys (id)');
        $this->addSql('ALTER TABLE services ADD categorys_id INT DEFAULT NULL, ADD prix_ttc INT DEFAULT NULL');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169A96778EC FOREIGN KEY (categorys_id) REFERENCES categorys (id)');
        $this->addSql('CREATE INDEX IDX_7332E169A96778EC ON services (categorys_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169A96778EC');
        $this->addSql('ALTER TABLE categorys DROP FOREIGN KEY FK_F76B7134A96778EC');
        $this->addSql('DROP TABLE categorys');
        $this->addSql('DROP INDEX IDX_7332E169A96778EC ON services');
        $this->addSql('ALTER TABLE services DROP categorys_id, DROP prix_ttc');
    }
}
