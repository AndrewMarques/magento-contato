<?php

/**
 * @category Hibrido
 * @package Hibrido_Contato
 * @author Hibrido <hibrido@souhibrido.com.br>
 */
class Hibrido_Contato_IndexController extends Mage_Core_Controller_Front_Action
{
    const XML_PATH_EMAIL_RECIPIENT  = 'contacts/email/recipient_email';
    const XML_PATH_EMAIL_SENDER     = 'contacts/email/sender_email_identity';
    const XML_PATH_ENABLED          = 'contacts/contacts/enabled';

    const XML_TEMPLATE   = 'hibrido_contato';

    /**
     * @access public
     * @return string
     */
    public function indexAction()
    {
        $response = $this->getResponse();
        $response->setHeader('Content-Type', 'application/json', true);

        $post = $this->getRequest()->getPost();

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        try {
            if ( ! $post) {
                throw new Exception();
            }

            $mailTemplate = Mage::getModel('core/email_template');

            /* @var $mailTemplate Mage_Core_Model_Email_Template */
            $mailTemplate->setDesignConfig(array('area' => 'frontend'))
                ->setReplyTo($post['email'])
                ->sendTransactional(
                    self::XML_TEMPLATE,
                    Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER),
                    Mage::getStoreConfig(self::XML_PATH_EMAIL_RECIPIENT),
                    null,
                    array('fields' => $post)
                );

            if ( ! $mailTemplate->getSentSuccess()) {
                throw new Exception();
            }

            $translate->setTranslateInline(true);

            $response->setBody(json_encode(array(
                'sucesso' => true,
                'mensagem' => Mage::helper('contato')->__('Your inquiry was submitted and will be responded to as soon as possible. Thank you for contacting us.')
            )));
        } catch (Exception $e) {
            $response->setBody(json_encode(array(
                'sucesso' => false,
                'mensagem' => Mage::helper('contato')->__('Unable to submit your request. Please, try again later')
            )));
        }
    }
}
