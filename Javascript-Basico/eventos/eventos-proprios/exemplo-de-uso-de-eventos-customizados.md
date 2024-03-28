Um exemplo prático de uso de um evento customizado em uma aplicação real pode ser a criação de um sistema de notificações personalizadas. Este sistema pode disparar um evento customizado sempre que uma nova notificação é criada, permitindo que diferentes partes da aplicação reajam a essa notificação de maneira independente.

Vamos criar um exemplo onde uma notificação é criada e disparada como um evento customizado, e duas partes da aplicação (um cabeçalho e uma barra lateral) escutam esse evento para atualizar suas informações de acordo.

1. **Criação do evento customizado**: Primeiro, definimos o evento customizado que será disparado quando uma nova notificação for criada.

```javascript
// Criação do evento customizado
const novaNotificacaoEvent = new CustomEvent('novaNotificacao', {
    detail: {
        mensagem: 'Nova mensagem recebida!',
        data: new Date()
    }
});
```

2. **Disparo do evento**: Quando uma nova notificação é criada, disparamos o evento customizado.

```javascript
function criarNotificacao() {
 // Aqui, você pode adicionar a lógica para criar a notificação
 // e então disparar o evento
    document.dispatchEvent(novaNotificacaoEvent);
}
```

3. **Escuta do evento**: As partes da aplicação que precisam reagir à nova notificação escutam o evento customizado.

```javascript
// Escuta do evento no cabeçalho
document.addEventListener('novaNotificacao', function(e) {
    console.log('Cabeçalho recebeu nova notificação:', e.detail.mensagem);
    // Atualiza o cabeçalho com a nova mensagem
});

// Escuta do evento na barra lateral
document.addEventListener('novaNotificacao', function(e) {
    console.log('Barra lateral recebeu nova notificação:', e.detail.mensagem);
    // Atualiza a barra lateral com a nova mensagem
});
```

4. **HTML para o exemplo**: Para que o exemplo funcione, você precisa de um elemento HTML que possa ser selecionado pelo JavaScript.

```html
<button onclick="criarNotificacao()">Criar Notificação</button>
```

----

Links úteis:
- https://developer.mozilla.org/pt-BR/docs/Learn/JavaScript/Building_blocks/Events
- https://caffeinealgorithm.com/blog/manipulacao-de-eventos-em-javascript
- https://www.freecodecamp.org/portuguese/news/o-metodo-addeventlistener-exemplo-de-codigo-com-listener-de-eventos-em-javascript/
- https://pt.stackoverflow.com/questions/331560/como-criar-e-usar-eventos-personalizados
- https://blog.dankicode.com/eventos-em-javascript/
- https://www.devmedia.com.br/trabalhando-com-eventos-em-javascript/28521
- https://www.freecodecamp.org/portuguese/news/como-programar-seu-proprio-emissor-de-eventos-no-node-js-um-guia-passo-a-passo/
- https://www.mundojs.com.br/2022/07/02/como-criar-eventos-javascript-customizados/
- https://wbruno.com.br/javascript-puro/como-criar-eventos-personalizados-customevents-no-javascript/
- https://developer.mozilla.org/es/docs/Learn/JavaScript/Building_blocks/Events
- https://www.javascriptprogressivo.net/p/eventos-em-javascript.html
- https://backefront.com.br/custom-event-javascript/
- https://www.devmedia.com.br/web-components-na-pratica/32476
- https://www.devmedia.com.br/javascript-facil-com-jquery-interacao-com-eventos-animacoes-e-ajax/8521
- https://programadoresdepre.com.br/javascript-guia-sobre-eventos/
