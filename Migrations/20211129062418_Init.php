<?php

namespace Application\Migrations;

use DevNet\Entity\Migration\AbstractMigration;
use DevNet\Entity\Migration\MigrationBuilder;

class Init extends AbstractMigration
{
    public function up(MigrationBuilder $builder): void
    {
        // table User
        $builder->createTable('User', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('Username')->type('string', 60)->nullable(false);
            $table->column('Pasword')->type('string', 60)->nullable(false);
            $table->uniqueConstraint('Username');
            $table->primaryKey('Id');
        });

        // table Role
        $builder->createTable('Role', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('Name')->type('string', 45)->default("customer");
            $table->uniqueConstraint('Name');
            $table->primaryKey('Id');
        });

        // table UserRole
        $builder->createTable('UserRole', function ($table) {
            $table->column('UserId')->type('integer')->nullable(false);
            $table->column('RoleId')->type('integer')->nullable(false);
            $table->foreignKey('UserId')->references('User', 'Id')->OnDelete('no action');
            $table->foreignKey('RoleId')->references('Role', 'Id')->OnDelete('no action');
            $table->primaryKey('UserId', 'RoleId');
        });

        // table Country
        $builder->createTable('Country', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('Name')->type('string', 45);
            $table->uniqueConstraint('Name');
            $table->primaryKey('Id');
        });

        // table State
        $builder->createTable('State', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('CountryId')->type('integer')->nullable(false);
            $table->column('Name')->type('string', 45);
            $table->uniqueConstraint('Name');
            $table->primaryKey('Id');
            $table->foreignKey('CountryId')->references('Country', 'Id')->OnDelete('no action');
        });

        // table Locality
        $builder->createTable('Locality', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('StateId')->type('integer')->nullable(false);
            $table->column('Name')->type('string', 45);
            $table->uniqueConstraint('Name');
            $table->primaryKey('Id');
            $table->foreignKey('StateId')->references('State', 'Id')->OnDelete('no action');
        });

        // table Location
        $builder->createTable('Location', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('LocalityId')->type('integer')->nullable(false);
            $table->column('Adress')->type('string', 60);
            $table->column('PostalCode')->type('string', 10);
            $table->primaryKey('Id');
            $table->foreignKey('LocalityId')->references('Locality', 'Id')->OnDelete('no action');
        });

        // table Profile
        $builder->createTable('Profile', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('UserId')->type('integer')->nullable(false);
            $table->column('LocationId')->type('integer')->nullable(false);
            $table->column('Photo')->type('string', 60);
            $table->column('FirstName')->type('string', 60);
            $table->column('Lastname')->type('string', 60);
            $table->column('Email')->type('string', 60);
            $table->column('PhoneNumber')->type('string', 60);
            $table->uniqueConstraint('Email');
            $table->uniqueConstraint('PhoneNumber');
            $table->primaryKey('Id');
            $table->foreignKey('UserId')->references('User', 'Id')->OnDelete('no action');
            $table->foreignKey('LocationId')->references('Location', 'Id')->OnDelete('no action');
        });

        // table Category
        $builder->createTable('Category', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('ParentId')->type('integer');
            $table->column('Name')->type('string', 60);
            $table->column('Description')->type('string', 255);
            $table->column('IconName')->type('string', 25);
            $table->uniqueConstraint('Name');
            $table->primaryKey('Id');
        });

        // table Item
        $builder->createTable('Item', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('UserId')->type('integer')->nullable(false);
            $table->column('CategoryId')->type('integer')->nullable(false);
            $table->column('Name')->type('string', 60);
            $table->column('Description')->type('string');
            $table->primaryKey('Id');
            $table->foreignKey('UserId')->references('User', 'Id')->OnDelete('no action');
            $table->foreignKey('CategoryId')->references('Category', 'Id')->OnDelete('no action');
        });

        // table Specification
        $builder->createTable('Specification', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('ItemId')->type('integer')->nullable(false);
            $table->column('Name')->type('string', 60);
            $table->primaryKey('Id');
            $table->foreignKey('ItemId')->references('Item', 'Id')->OnDelete('no action');
        });

        // table Advert
        $builder->createTable('Advert', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('UserId')->type('integer')->nullable(false);
            $table->column('ItemId')->type('integer')->nullable(false);
            $table->column('LocalityId')->type('integer')->nullable(false);
            $table->column('Name')->type('string', 60);
            $table->column('Excerpt')->type('string', 255);
            $table->column('Description')->type('string');
            $table->column('Availability')->type('bool');
            $table->column('Date')->type('DateTime');
            $table->primaryKey('Id');
            $table->foreignKey('UserId')->references('User', 'Id')->OnDelete('no action');
            $table->foreignKey('ItemId')->references('Item', 'Id')->OnDelete('no action');
            $table->foreignKey('LocalityId')->references('Locality', 'Id')->OnDelete('no action');
        });

        // table Attribute
        $builder->createTable('Attribute', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('AdvertId')->type('integer')->nullable(false);
            $table->column('SpecificationId')->type('integer')->nullable(false);
            $table->column('Value')->type('string', 45);
            $table->primaryKey('Id');
            $table->foreignKey('AdvertId')->references('Advert', 'Id')->OnDelete('no action');
            $table->foreignKey('SpecificationId')->references('Specification', 'Id')->OnDelete('no action');
        });

        // table Image
        $builder->createTable('Image', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('AdvertId')->type('integer')->nullable(false);
            $table->column('Title')->type('string', 60);
            $table->column('Caption')->type('string', 255);
            $table->column('Path')->type('string', 60);
            $table->primaryKey('Id');
            $table->foreignKey('AdvertId')->references('Advert', 'Id')->OnDelete('no action');
        });

        // table Review
        $builder->createTable('Review', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('AdvertId')->type('integer')->nullable(false);
            $table->column('UserId')->type('integer')->nullable(false);
            $table->column('Rate')->type('integer');
            $table->column('Content')->type('text');
            $table->primaryKey('Id');
            $table->foreignKey('UserId')->references('User', 'Id')->OnDelete('no action');
            $table->foreignKey('AdvertId')->references('Advert', 'Id')->OnDelete('no action');
        });

        // table Message
        $builder->createTable('Message', function ($table) {
            $table->column('Id')->type('integer')->identity();
            $table->column('SenderId')->type('integer')->nullable(false);
            $table->column('ReceiverId')->type('integer')->nullable(false);
            $table->column('Title')->type('string', 60);
            $table->column('Content')->type('string');
            $table->column('Date')->type('DateTime');
            $table->primaryKey('Id');
            $table->foreignKey('SenderId')->references('User', 'Id')->OnDelete('no action');
            $table->foreignKey('ReceiverId')->references('User', 'Id')->OnDelete('no action');
        });
    }

    public function down(MigrationBuilder $builder): void
    {
        $builder->dropTable('Message');
        $builder->dropTable('Review');
        $builder->dropTable('Image');
        $builder->dropTable('Attribute');
        $builder->dropTable('Advert');
        $builder->dropTable('Specification');
        $builder->dropTable('Item');
        $builder->dropTable('Category');
        $builder->dropTable('Profile');
        $builder->dropTable('Location');
        $builder->dropTable('Locality');
        $builder->dropTable('State');
        $builder->dropTable('Country');
        $builder->dropTable('UserRole');
        $builder->dropTable('Role');
        $builder->dropTable('User');
    }
}
