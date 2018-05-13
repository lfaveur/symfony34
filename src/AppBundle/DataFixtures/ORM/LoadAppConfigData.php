<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\AppConfig;

class LoadAppConfigData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        //Config 1
        $configs = array(
            array('CONFIG_1', 'value1', 'name 1'),
            array('CONFIG_1', 'value2', 'name 2')
        );

        foreach ($configs as $i ){
            $config = new AppConfig();
            $config->setType($i['0']);
            $config->setValue($i['1']);
            $config->setName($i['2']);

            $manager->persist($config);
        }

        //Config 2
        $configs = array(
            array('CONFIG_2', 'value1', 'name 1'),
            array('CONFIG_2', 'value2', 'name 2'),
            array('CONFIG_2', 'value3', 'name 3')
        );

        foreach ($configs as $i ){
            $config = new AppConfig();
            $config->setType($i['0']);
            $config->setValue($i['1']);
            $config->setName($i['2']);

            $manager->persist($config);
        }

        $manager->flush();
    }
}