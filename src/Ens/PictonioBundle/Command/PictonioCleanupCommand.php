<?php

namespace Ens\PictonioBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ens\PictonioBundle\Entity\Job;
 
class PictonioCleanupCommand extends ContainerAwareCommand {
 
  protected function configure()
  {
    $this
      ->setName('ens:pictonio:cleanup')
      ->setDescription('Cleanup Pictonio database')
      ->addArgument('days', InputArgument::OPTIONAL, 'The email', 90)
    ;
  }
 
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $days = $input->getArgument('days');
 
    $em = $this->getContainer()->get('doctrine')->getManager();
    $nb = $em->getRepository('EnsPictonioBundle:Job')->cleanup($days);
 
    $output->writeln(sprintf('Removed %d stale jobs', $nb));
  }
}