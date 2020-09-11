<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911084004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bm_customers ADD firstname VARCHAR(100) NOT NULL, ADD lastname VARCHAR(100) NOT NULL, DROP password, DROP roles');
        $this->addSql('DROP INDEX uniq_email ON bm_users');
        $this->addSql('ALTER TABLE bm_users ADD name VARCHAR(255) NOT NULL, ADD description LONGTEXT DEFAULT NULL, DROP email, DROP password, DROP roles');
        $this->addSql('CREATE UNIQUE INDEX uniq_name ON bm_users (name)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bm_customers ADD password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD roles JSON NOT NULL, DROP firstname, DROP lastname');
        $this->addSql('DROP INDEX uniq_name ON bm_users');
        $this->addSql('ALTER TABLE bm_users ADD password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD roles JSON NOT NULL, DROP description, CHANGE name email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX uniq_email ON bm_users (email)');
    }
}
