<?php

namespace hsTrading\FrontEndBundle\Services;

use Symfony\Component\DependencyInjection\Container;
use hsTrading\FrontEndBundle\Utils\EchTools;

/**
 * Description of MailService
 *
 * @author SSH1
 */
class MailService
{

    private $oContainer;
    private $sNoReplyMail;

    public function __construct(Container $oContainer)
    {
        $this->oContainer   = $oContainer;
        $this->sNoReplyMail = array($this->oContainer->getParameter('no-reply_mail') => 'Echrili.tn');
    }

    public function getLogo($psImg)
    {
        $sPath = DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $psImg . '.png';
        return \Swift_Image::fromPath($this->oContainer->getParameter('kernel.root_dir') . $sPath);
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
    public function sendMail($psMailTo, $psUrl, $psSubject, $oUser, $Template, $psLocale, $psCpltSubject = '')
    {

        $psSubject = $this->oContainer->get('translator')->trans($psSubject, array(), 'messages', $psLocale) . ' ' . $psCpltSubject;
        $oLogger   = $this->oContainer->get('mail_logger');
        try
        {
            $oMailer = $this->oContainer->get('mailer');

            $oMail = \Swift_Message::newInstance();

            $sBody = $this->oContainer->get('templating')->render($Template, array(
                'url' => $psUrl,
                'logo' => $oMail->embed(\Swift_Image::fromPath(EchTools::getStdPath($this->oContainer->getParameter('kernel.root_dir') . '\..\web\img\logo.png'))),
                'facebook' => $oMail->embed(\Swift_Image::fromPath(EchTools::getStdPath($this->oContainer->getParameter('kernel.root_dir') . '\..\web\img\facebook.png'))),
                'twitter' => $oMail->embed(\Swift_Image::fromPath(EchTools::getStdPath($this->oContainer->getParameter('kernel.root_dir') . '\..\web\img\twitter.png'))),
                'data' => $oUser));

            $oMail->setSubject($psSubject)
                    ->setFrom($this->sNoReplyMail)
                    ->setTo($psMailTo)
                    ->setBody($sBody)
                    ->setContentType('text/html');

            $bSended = $oMailer->send($oMail);

            $transport = $oMailer->getTransport();
            if ($transport instanceof \Swift_Transport_SpoolTransport)
            {
                $spool = $transport->getSpool();
                $sent  = $spool->flushQueue($this->oContainer->get('swiftmailer.transport.real'));
                if (is_array($psMailTo))
                {
                    $psMailTo = implode(",", $psMailTo);
                }
                $oLogger->info("Envoie $psSubject vers $psMailTo");

                return true;
            }
            return $bSended;
        }
        catch (\Exception $ex)
        {
            $oLogger->error($ex->getMessage());
            throw $ex;
        }
        return false;
    }

}
