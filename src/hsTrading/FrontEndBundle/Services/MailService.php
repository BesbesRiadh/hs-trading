<?php

namespace hsTrading\FrontEndBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use hsTrading\FrontEndBundle\Utils\EchTools;

/**
 * Description of MailService
 *
 * @author SSH1
 */
class MailService {

    private $oContainer;
    private $sNoReplyMail;

    public function __construct(Container $oContainer) {
        $this->oContainer = $oContainer;
        $this->sNoReplyMail = $this->oContainer->getParameter('noreply_mail');
        $this->sContactMail = $this->oContainer->getParameter('contact_mail');
    }

    /**
     * Envoie le mail de changement mot de passe
     *
     * @param string $psFrom
     * @param string $psMailTo
     * @param string $psBody
     * @return boolean
     *
     * @author Walid Saadaoui
     */
    public function sendMail($oData) {
        $oLogger = $this->oContainer->get('mail_logger');
        try {
            $oMailer = $this->oContainer->get('mailer');

            $oMail = \Swift_Message::newInstance();

            $sBody = $this->oContainer->get('templating')->render('hsTradingFrontEndBundle:Mail:index.html.twig', array(
                'logo' => $oMail->embed(\Swift_Image::fromPath(EchTools::getStdPath($this->oContainer->getParameter('kernel.root_dir') . '\..\web\img\logo.png'))),
                'facebook' => $oMail->embed(\Swift_Image::fromPath(EchTools::getStdPath($this->oContainer->getParameter('kernel.root_dir') . '\..\web\img\facebook.png'))),
                'data' => $oData));

            $oMail->setSubject('Nouveau message de contact')
                    ->setFrom($this->sNoReplyMail)
                    ->setTo($this->sContactMail)
                    ->setBody($sBody)
                    ->setContentType('text/html');

            $bSended = $oMailer->send($oMail);

            $transport = $oMailer->getTransport();
            if ($transport instanceof \Swift_Transport_SpoolTransport) {
                $spool = $transport->getSpool();
                $sent = $spool->flushQueue($this->oContainer->get('swiftmailer.transport.real'));
                if (is_array($this->sContactMail)) {
                    $this->sContactMail = implode(",", $this->sContactMail);
                }
                $oLogger->info("Envoie Nouveau message de contact vers $this->sContactMail");

                return true;
            }
            return $bSended;
        } catch (\Exception $ex) {
            $oLogger->error($ex->getMessage());
            throw $ex;
        }
        return false;
    }

}
