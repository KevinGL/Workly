<?php

namespace App\Command;

use App\Repository\CandidacyRepository;
use App\Repository\SocietyRepository;
use App\Service\SmsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:check-relaunches',
    description: 'Add a short description for your command',
)]
class CheckRelaunchesCommand extends Command
{
    private SocietyRepository $socRepo;
    private CandidacyRepository $candRepo;
    private SmsService $smsService;
    
    public function __construct(SocietyRepository $socRepo, CandidacyRepository $candRepo, SmsService $smsService)
    {
        parent::__construct();

        $this->socRepo = $socRepo;
        $this->candRepo = $candRepo;
        $this->smsService = $smsService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $message = "N'oubliez pas de relancer les sociétés suivantes :\n";

        $relaunchesSoc = $this->socRepo->findRelaunchesToday();
        foreach($relaunchesSoc as $rs)
        {
            $message .= "- " . $rs->getName() . "\n";
            $message .= "    Tél : " . ($rs->getPhoneNumber() ?? "N/A") . "\n";
            $message .= "    Email : " . ($rs->getEmail() ?? "N/A"). "\n";
            $message .= "    LinkedIn : " .  ($rs->getLinkedIn() ?? "N/A") . "\n";
        }

        $relaunchesCand = $this->candRepo->findRelaunchesToday();
        foreach($relaunchesCand as $rc)
        {
            $message .= "- " . $rc->getSociety() . " (" . $rc->getLink() . ")\n";
        }

        if(count($relaunchesSoc) > 0 || count($relaunchesCand) > 0)
        {
            $this->smsService->send("+33642427521", $message);

            $io->success('SMS sent');
        }

        return Command::SUCCESS;
    }
}
