export function sortedTable(tag) {
    let colToSort = this.colToSort;
    let functionObj = [];
    this.result.sort(function (a, b) {
        if (isNumeric(a[colToSort]) || isCurrency(a[colToSort])) return Number(a[colToSort]) - Number(b[colToSort]);
        if (a[colToSort] > b[colToSort]) return 1;
        if (a[colToSort] < b[colToSort]) return -1;
        else return 0;
    });
    if (tag == null) {
        let curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
        let table = '<div class="row"><div class="th">STT</div>';
        for (let i = 0; i < this.headers.length; i++) {
            this.colToSort = this.alias[i];
            table += '<div class="th" onclick=\'sortedTable.call(' + JSON.stringify(this) + ', this)\'>' + this.headers[i] + '</div>';
        }
        table += '<div class="th">chức năng</div></div>';
        for (let i = 0; i < this.result.length; i++) {
            table += '<div class="row" style="height: 70px;" id="' + i + '"><div class="col">' + (i + 1) + '</div>';
            for (let j = 0; j < this.alias.length; j++) {
                let value = this.result[i][this.alias[j]];
                switch (this.type[j]) {
                    case "string":
                    case "number":
                        break;
                    case "date":
                        value = new moment(value).format('DD/MM/YYYY HH:mm:ss');
                        break;
                    case "currency":
                        value = curr.format(value);
                        break;
                    case "img":
                        value = '<img alt="image" width="70%" height="65px" src="' + value + '"/>';
                        break;
                    default:
                        break;
                }
                table += '<div class="col">' + value + '</div>';
            }
            for (let j = 0; j < this.functionCalls.length; j++) {
                functionObj.push({
                    id: i,
                    functionCalls: this.functionCalls[j],
                    result: this.result[i],
                    pActive: this.pActive
                });
                table += '<div class="col" id="' + this.functionCalls[j] + '_' + i + '"><button onclick=\'' + this.functionCalls[j] + '.call(' + JSON.stringify(functionObj[i]) + ', event, true)\'>' + this.buttonName + '</button></div>';
            }
            table += '</div>'
        }
        jq351(this.id).html(table);
        page('trang', this.pages, this.toPage, this.pActive);
        for (let i = 0; i < functionObj.length; i++)
            this.functions[0].call(functionObj[i], event, false);
    } else {
        let curr = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});
        switch (tag.className) {
            case "th asc":
                this.result.reverse();
                tag.className = "th dsc";
                break;
            case "th dsc":
                tag.className = "th asc";
                break;
            default:
                tag.className = "th asc";
                break;
        }
        let tags = document.getElementsByClassName('th');
        for (let i = 1; i < tags.length; i++) {
            if (tags[i] != tag) tags[i].className = 'th';
        }
        var removalElement = $(".row");
        for (let i = 1; i < removalElement.length; i++)
            removalElement[i].remove();
        let table = '';
        for (let i = 0; i < this.result.length; i++) {
            table += '<div class="row" id="' + i + '"><div class="col">' + (i + 1) + '</div>';
            for (let j = 0; j < this.alias.length; j++) {
                let value = this.result[i][this.alias[j]];
                switch (this.type[j]) {
                    case "string":
                    case "number":
                        break;
                    case "date":
                        value = new moment(value).format('DD/MM/YYYY HH:mm:ss');
                        break;
                    case "currency":
                        value = curr.format(value);
                        break;
                    case "img":
                        value = '<img alt="image" width="70%" height="65px" src="' + value + '"/>';
                        break;
                    default:
                        break;
                }
                table += '<div class="col">' + value + '</div>';
            }
            for (let j = 0; j < this.functionCalls.length; j++) {
                functionObj.push({
                    id: i,
                    functionCalls: this.functionCalls[j],
                    result: this.result[i],
                    pActive: this.pActive
                });
                table += '<div class="col" id="' + this.functionCalls[j] + '_' + i + '"><button onclick=\'' + this.functionCalls[j] + '.call(' + JSON.stringify(functionObj[i]) + ', event, true)\'>' + this.buttonName + '</button></div>';
            }
            table += '</div>'
        }
        jq351(this.id).append(table);
    }
    let width = 100/(this.headers.length + 2);
    let theaders = document.getElementsByClassName('th');
    let cols = document.getElementsByClassName('col');
    for (let i = 0; i < cols.length; i++) {
        cols[i].style.width = `${width}%`;
    }
    for (let i = 0; i < theaders.length; i++) {
        theaders[i].style.width = `${width}%`;
    }
    const eles = document.getElementsByClassName('row');
    for (let i = 1; i < eles.length; i++) {
        const menu = document.getElementById('menu_' + (i - 1));
        eles[i].addEventListener('contextmenu', function (e) {
            e.preventDefault();
            const position = getPosition(e);
            const x = position.x;
            const y = position.y;
            menu.style.top = `${y}px`;
            menu.style.left = `${x}px`;
            menu.style.display = 'block'
            for (let j = 1; j < eles.length; j++) {
                if (i != j) {
                    document.getElementById('menu_' + (j - 1)).style.display = 'none';
                }
            }
            document.addEventListener('click', documentClickHandler);
        }, false);
        const documentClickHandler = function (e) {
            const isClickedOutside = !menu.contains(e.target);
            if (isClickedOutside) {
                menu.style.display = 'none';
                document.removeEventListener('click', documentClickHandler);
            }
        };
    }
}