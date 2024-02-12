// <pre data-id="output"></pre>

function toLog(data = [], toAppend = true) {
    let outputElement = document.querySelector('[data-id="output"]');

    const toJson = item => JSON.stringify(item, null, 4);

    const putItem = item => {
        let previousContent = toAppend ? ((`${outputElement.innerHTML}`).trim()) : '';
        item = item && ['Array', 'Object'].includes(item.constructor.name) ? toJson(item) : item;
        let contentToAppend = `${previousContent}\n${item}`;
        outputElement.innerHTML = contentToAppend;
    }

    data = Array.isArray(data) ? data : [data];

    if (!data || !data?.forEach) {
        putItem(data)
        return;
    }

    data?.forEach(item => putItem(item))
}

function presetFileByFileName()
{
    if (!['Document', ''].includes(document.querySelector('head title').innerText.trim())) {
        return;
    }

    let name = location.pathname.slice(location.pathname.lastIndexOf('/')+1).split('.')[0] || ''
    name = name.trim();

    if (!name) {
        return
    }

    document.querySelectorAll('head title, [data-id="page-title"]').forEach(item => item.innerText = name)
}

window.addEventListener('load', (event) => {
    presetFileByFileName();
});
