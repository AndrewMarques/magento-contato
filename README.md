# magento-contato

módulo para facilitar a integração de formulários de contato em uma loja magento

# como usar

é só criar um form com o id de hibrido-contato-form contendo um button com type
igual a submit e para as respostas é só criar um elemento (pode ser fora ou
dentro do form, tanto faz) com o id de hibrido-contato-feedback

```
<div id="hibrido-contato-feedback"></div>
<form id="hibrido-contato-form">
    <input type="text" name="campo-1">
    <button type="submit">enviar</button>
</form>
```

quando o botão de submit for clicado algumas coisas acontecerão:

* o botão trocará de texto (para carregando)
* no botão será colocado um atributo disabled
* a mensagem do campo de feedback será limpa
* o campo de feedback será escondido

quando a requisição for sucesso:

* o elemento feedback ganhará uma classe `sucesso`

quando a requisição for erro:

* o elemento feedback ganhará uma class `erro`

quando a requisição for completa independete do resultado:

* o campo de feedback será colocado com a mensagem
* o botão voltará a ter o texto antigo
* no botão será removido o attributo disabled

