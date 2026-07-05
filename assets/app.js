// Collapsible Sidebar Menus
function toggleSubmenu(id, btn) {
    const menu = document.getElementById(id);
    const isOpened = menu.classList.contains('open');
    
    // Toggle
    if (isOpened) {
        menu.classList.remove('open');
        btn.classList.remove('open');
    } else {
        menu.classList.add('open');
        btn.classList.add('open');
    }
}

// Navigation between views
function showView(viewId, linkElement) {
    // Hide all views
    const views = document.querySelectorAll('.view-panel');
    views.forEach(view => view.classList.remove('active'));

    // Show target view
    document.getElementById(viewId).classList.add('active');

    // Deactivate all nav links
    const links = document.querySelectorAll('.submenu-link, .standalone-link');
    links.forEach(l => l.classList.remove('active'));

    // Activate current
    linkElement.classList.add('active');
}

// Copy plain text to clipboard
function copySnippet(id) {
    const text = document.getElementById(id).innerText;
    navigator.clipboard.writeText(text).then(() => {
        showToastNotification();
    });
}

function showToastNotification() {
    const toast = document.getElementById('toast-notif');
    toast.classList.add('show');
    setTimeout(() => {
        toast.classList.remove('show');
    }, 2000);
}

// --- Interactive Code Generator State & Logic ---
let colData = [
    { name: 'department_id', type: 'string', length: '36', nullable: true, after: 'user_id' }
];

function addNewColumnToGenerator() {
    colData.push({
        name: 'new_column_' + (colData.length + 1),
        type: 'string',
        length: '',
        nullable: true,
        after: ''
    });
    renderColumnsForm();
    runCodeGenerator();
}

// Remove column from generator
function removeColumnFromGenerator(index) {
    colData.splice(index, 1);
    renderColumnsForm();
    runCodeGenerator();
}

// Edit column fields dynamically
function editColumnField(index, field, value) {
    colData[index][field] = value;
    runCodeGenerator();
}

function renderColumnsForm() {
    const container = document.getElementById('gen-columns-list');
    container.innerHTML = '';

    colData.forEach((col, idx) => {
        const item = document.createElement('div');
        item.className = 'gen-column-item';
        item.innerHTML = `
            <div class="gen-column-header">
                <span>CỘT ĐỊNH NGHĨA #${idx + 1}</span>
                <button class="btn-remove" onclick="removeColumnFromGenerator(${idx})">XÓA</button>
            </div>
            <div class="gen-row-grid">
                <div class="gen-form-group" style="margin-bottom:0; gap:2px;">
                    <label style="font-size:10px;">Tên trường:</label>
                    <input type="text" class="gen-form-control" style="padding:4px 6px; font-size:12px;" value="${col.name}" 
                        oninput="editColumnField(${idx}, 'name', this.value)">
                </div>
                <div class="gen-form-group" style="margin-bottom:0; gap:2px;">
                    <label style="font-size:10px;">Kiểu dữ liệu:</label>
                    <select class="gen-form-control" style="padding:4px 6px; font-size:12px;" 
                        onchange="editColumnField(${idx}, 'type', this.value)">
                        <option value="string" ${col.type === 'string' ? 'selected' : ''}>string</option>
                        <option value="integer" ${col.type === 'integer' ? 'selected' : ''}>integer</option>
                        <option value="boolean" ${col.type === 'boolean' ? 'selected' : ''}>boolean</option>
                        <option value="text" ${col.type === 'text' ? 'selected' : ''}>text</option>
                        <option value="decimal" ${col.type === 'decimal' ? 'selected' : ''}>decimal</option>
                        <option value="json" ${col.type === 'json' ? 'selected' : ''}>json</option>
                    </select>
                </div>
            </div>
            <div class="gen-row-grid" style="margin-top:6px; margin-bottom:0;">
                <div class="gen-form-group" style="margin-bottom:0; gap:2px;">
                    <label style="font-size:10px;">Độ dài (nếu có):</label>
                    <input type="text" class="gen-form-control" style="padding:4px 6px; font-size:12px;" value="${col.length}" placeholder="e.g. 36"
                        oninput="editColumnField(${idx}, 'length', this.value)">
                </div>
                <div class="gen-form-group" style="margin-bottom:0; gap:2px;">
                    <label style="font-size:10px;">Đặt sau cột:</label>
                    <input type="text" class="gen-form-control" style="padding:4px 6px; font-size:12px;" value="${col.after}" placeholder="e.g. user_id"
                        oninput="editColumnField(${idx}, 'after', this.value)">
                </div>
            </div>
            <div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
                <label style="font-size:11px; display:flex; align-items:center; gap:4px; cursor:pointer;">
                    <input type="checkbox" ${col.nullable ? 'checked' : ''} onchange="editColumnField(${idx}, 'nullable', this.checked)"> Nullable
                </label>
            </div>
        `;
        container.appendChild(item);
    });
}

function runCodeGenerator() {
    const tableName = document.getElementById('input-table').value;
    const className = document.getElementById('input-class').value || 'MyTableExtension';
    const priorityVal = document.getElementById('input-priority').value || '10';

    document.getElementById('ide-tab-label').textContent = className + '.php';

    let colsMarkup = '';
    colData.forEach((col, idx) => {
        let code = `            ColumnDefinition::make('${col.name}', '${col.type}')`;
        if (col.type === 'string' && col.length) {
            code += `\n                ->length(${col.length})`;
        }
        if (col.nullable) {
            code += `\n                ->nullable()`;
        } else {
            code += `\n                ->nullable(false)`;
        }
        if (col.after) {
            code += `\n                ->after('${col.after}')`;
        }
        colsMarkup += code;
        if (idx < colData.length - 1) {
            colsMarkup += ',\n\n';
        }
    });

    const template = `<?php

namespace App\\Extensions;

use Spatie\\LaravelPackageTools\\Contracts\\TableExtension;
use Spatie\\LaravelPackageTools\\Extensions\\ColumnDefinition;

class ${className} implements TableExtension
{
    public function targetTable(): string
    {
        return '${tableName}';
    }

    public function columns(): array
    {
        return [
${colsMarkup}
        ];
    }

    public function priority(): int
    {
        return ${priorityVal};
    }
}`;

    document.getElementById('output-generator-code').innerHTML = highlightPHP(template);
}

function highlightPHP(code) {
    let html = code
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');

    // Comments
    html = html.replace(/(\/\/.*)/g, '<span class="cmt">$1</span>');

    // Strings
    html = html.replace(/('[^']*')/g, '<span class="str">$1</span>');

    // Keywords
    const keywords = [
        'namespace', 'use', 'class', 'implements', 'public', 'function', 
        'return', 'string', 'array', 'int', 'priority'
    ];
    keywords.forEach(kw => {
        const reg = new RegExp('\\b' + kw + '\\b', 'g');
        html = html.replace(reg, `<span class="kw">${kw}</span>`);
    });

    // Classes
    const classes = [
        'TableExtension', 'ColumnDefinition', 'MyTableExtension', 'MaintenancePlanExtension'
    ];
    classes.forEach(cls => {
        const reg = new RegExp('\\b' + cls + '\\b', 'g');
        html = html.replace(reg, `<span class="cls">${cls}</span>`);
    });

    // Functions
    html = html.replace(/\b([a-zA-Z_][a-zA-Z0-9_]*)(?=\()/g, '<span class="fn">$1</span>');

    // Numbers
    html = html.replace(/\b(\d+)\b/g, '<span class="num">$1</span>');

    // PHP Tag
    html = html.replace(/&lt;\?php/g, '<span class="kw">&lt;?php</span>');

    return html;
}

function copyGenCodeToClipboard() {
    const pre = document.getElementById('output-generator-code');
    navigator.clipboard.writeText(pre.innerText).then(() => {
        showToastNotification();
    });
}

// Initialize Form & Code Output
renderColumnsForm();
runCodeGenerator();
