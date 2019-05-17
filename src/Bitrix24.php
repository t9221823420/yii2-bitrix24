<?php
/**
 * Created by PhpStorm.
 * User: bw
 * Date: 26.04.2019
 * Time: 20:26
 */

namespace yozh\bitrix24;

use Psr\Log\LoggerInterface;
use Yii;
use yozh\bitrix24\Credentials;
use Bitrix24\Exceptions\Bitrix24Exception;

class Bitrix24 extends \Bitrix24\Bitrix24
{
    /**
     * @var Credentials
     */
    protected $_credentials;
    
    /**
     * Bitrix constructor.
     * @param bool $isSaveRawResponse
     * @param LoggerInterface|null $logger
     * @throws Bitrix24Exception
     */
    public function __construct( $isSaveRawResponse = false, ?LoggerInterface $logger = null )
    {
        parent::__construct( $isSaveRawResponse, $logger );
        
        $this->setApplicationScope( explode( ',', Yii::$app->params['B24_APPLICATION_SCOPE'] ) );
        $this->setApplicationId( Yii::$app->params['B24_APPLICATION_ID'] );
        $this->setApplicationSecret( Yii::$app->params['B24_APPLICATION_SECRET'] );
        
        $this->setOnExpiredToken( [ $this, 'refreshAccessToken' ] );
    }
    
    /**
     * @param string $methodName
     * @param array $additionalParameters
     * @return mixed
     * @throws Bitrix24Exception
     */
    public function call( $methodName, array $additionalParameters = [] )
    {
        if( $this->credentials === null ) {
            $this->fetchAccessToken();
        }
        
        return parent::call( $methodName, $additionalParameters );
    }
    
    /**
     * @throws \Exception
     */
    public function fetchAccessToken(): void
    {
        if( ( $this->credentials = Credentials::findOne( 1 ) ) === null ) {
            throw new \HttpRuntimeException( 500, "No access token found" );
        }
        
        $this->setDomain( $this->credentials->domain );
        $this->setMemberId( $this->credentials->member_id );
        $this->setAccessToken( $this->credentials->access_token );
        $this->setRefreshToken( $this->credentials->refresh_token );
        
        if( $this->credentials->expires < new \DateTime( 'now' ) ) {
            $this->refreshAccessToken();
        }
    }
    
    protected function refreshAccessToken(): void
    {
        $this->setRedirectUri( Url::home( true ) . '/bitrix24/install' );
        $result = $this->getNewAccessToken();
        
        if( $result['member_id'] === $this->credentials->member_id ) {
            
            $userData = [
                'access_token'  => $result['access_token'],
                'refresh_token' => $result['refresh_token'],
            ];
            
            $this->setCredentials( $userData );
            
            //saving for current run
            $this->setAccessToken( $this->credentials->access_token );
            $this->setRefreshToken( $this->credentials->refresh_token );
        }
        else {
            throw new Bitrix24Exception( 'Wrong member_id given' );
        }
    }
    
    /**
     * @param array $data
     * @throws \Exception
     */
    public function addNewCredentials( array $data ): void
    {
        if( isset(
            $data['domain'],
            $data['access_token'],
            $data['refresh_token'],
            $data['member_id'] )
        ) {
            
            if( !$this->credentials = Credentials::findOne( [ 'member_id' => $data['member_id'] ] ) ) {
                
                if( !$Credentials = Credentials::findOne( [ 'member_id' => $request->get( 'member_id' ) ] ) ) {
                    $Credentials = new Credentials();
                }
                
            }
            
            $this->setCredentials( $data, true );
        }
    }
    
    /**
     * @param array $data
     * @throws \Exception
     */
    public function setCredentials( array $data, bool $save = false ): void
    {
        //setting changed date
        $changed  = new \DateTime( 'now' );
        $expires  = clone $changed;
        $duration = 3600;
        if( isset( $data['expires_in'] ) && (int)$data['expires_in'] < 1 ) {
            $duration = (int)$data['expires_in'];
        }
        $expires->add( new \DateInterval( 'PT' . $duration . 'S' ) );
        
        $data['changed'] = $changed;
        $data['expires'] = $expires;
        
        $this->credentials->setAttributes( $data );
        
        !$save ?: $this->credentials->save();
    }
    
}