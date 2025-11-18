# Evolution API Laravel Package

Pacote Laravel para integração com Evolution API - WhatsApp Business API.

## Instalação

1. O pacote já está configurado no projeto
2. Publique o arquivo de configuração:
```bash
php artisan vendor:publish --provider="Kalezao\EvolutionApi\EvolutionApiServiceProvider"
```

3. Configure as variáveis de ambiente no `.env`:
```env
EVOLUTION_API_BASE_URL=https://sua-evolution-api.com
EVOLUTION_API_KEY=sua-api-key-aqui
EVOLUTION_API_TIMEOUT=30
EVOLUTION_API_DEFAULT_INSTANCE=instancia-padrao
```

## Uso

### Usando a Facade

```php
use Kalezao\EvolutionApi\Facades\EvolutionAPI;

// Enviar mensagem de texto
$response = EvolutionAPI::sendText('minha-instancia', '5511999999999', 'Olá! Esta é uma mensagem de teste.');

// Enviar mídia
$response = EvolutionAPI::sendMedia(
    'minha-instancia', 
    '5511999999999', 
    'image', 
    'https://exemplo.com/imagem.jpg',
    ['caption' => 'Legenda da imagem']
);

// Enviar status
$response = EvolutionAPI::sendStatus('minha-instancia', [
    'type' => 'text',
    'content' => 'Meu status de teste',
    'allContacts' => true
]);

// Criar instância
$response = EvolutionAPI::createInstance([
    'instanceName' => 'nova-instancia',
    'token' => 'token-da-instancia',
    'qrcode' => true,
    'integration' => 'WHATSAPP-BAILEYS'
]);

// Listar instâncias
$instances = EvolutionAPI::getInstances();
```

### Usando o Service Container

```php
use Kalezao\EvolutionApi\Services\EvolutionApiService;

class MeuController extends Controller
{
    public function __construct(
        private EvolutionApiService $evolutionApi
    ) {}

    public function enviarMensagem()
    {
        $response = $this->evolutionApi->sendText(
            'minha-instancia',
            '5511999999999',
            'Mensagem enviada via service!'
        );
        
        return response()->json($response);
    }
}
```

## Métodos Disponíveis

- `sendText($instance, $number, $text, $options = [])` - Enviar mensagem de texto
- `sendMedia($instance, $number, $mediaType, $media, $options = [])` - Enviar mídia
- `sendStatus($instance, $statusData)` - Enviar status
- `createInstance($instanceData)` - Criar nova instância
- `getInstance($instance)` - Obter informações da instância
- `getQrCode($instance)` - Obter QR code da instância
- `disconnectInstance($instance)` - Desconectar instância
- `deleteInstance($instance)` - Deletar instância
- `getInstances()` - Listar todas as instâncias

## Tratamento de Erros

O pacote lança `EvolutionApiException` em caso de erro:

```php
use Kalezao\EvolutionApi\Exceptions\EvolutionApiException;

try {
    $response = EvolutionAPI::sendText('instancia', 'numero', 'texto');
} catch (EvolutionApiException $e) {
    // Tratar erro
    Log::error('Erro ao enviar mensagem: ' . $e->getMessage());
}
```

## Configuração

O arquivo de configuração `config/evolution-api.php` contém:

```php
return [
    'base_url' => env('EVOLUTION_API_BASE_URL', 'https://api.evolution.com'),
    'api_key' => env('EVOLUTION_API_KEY'),
    'timeout' => env('EVOLUTION_API_TIMEOUT', 30),
    'default_instance' => env('EVOLUTION_API_DEFAULT_INSTANCE'),
];
```

