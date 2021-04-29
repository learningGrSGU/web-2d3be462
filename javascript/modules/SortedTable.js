export function sortedTable(tag) {
    let colToSort = this.colToSort;
    this.result.sort(function (a, b) {
        if (isNumeric(a[colToSort]) || isCurrency(a[colToSort])) return Number(a[colToSort]) - Number(b[colToSort]);
        if (a[colToSort] > b[colToSort]) return 1;
        if (a[colToSort] < b[colToSort]) return -1;
        else return 0;
    });
    if (tag == null) {
        let table = '<div class="row"><div class="th">STT</div>';
        for (let i = 0; i < this.headers.length; i++) {
            this.colToSort = this.alias[i];

            table += '<div class="th" onclick=\'sortedTable.apply(' + JSON.stringify(this) + ', [this])\'>' + this.headers[i] + '</div>';
        }
        table += '<div class="th">chức năng</div></div>';
        for (let i = 0; i < this.result.length; i++) {
            table += '<div class="row" id="' + i + '"><div class="col">' + (i + 1) + '</div>';
            for (let j = 0; j < this.alias.length; j++) {
                table += '<div class="col">' + this.result[i][this.alias[j]] + '</div>';
            }
            for (let j = 0; j < this.functionCalls.length; j++) {
                let functionObj = {
                    result: this.result[i],
                    pActive: this.pActive
                };
                table += '<div class="col" id="' + this.functionCalls[j] + '"><button onclick=\'' + this.functionCalls[j] + '.apply(' + JSON.stringify(functionObj) + ')\'>' + this.buttonName + '</button></div>';
            }
            table += '</div>'
        }
        jq351(this.id).html(table);
        page('trang', this.pages, 'qltk', this.pActive);
    } else {
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
        var removalElement = $(".row");
        for (let i = 1; i < removalElement.length; i++)
            removalElement[i].remove();
        let table = '';
        for (let i = 0; i < this.result.length; i++) {
            table += '<div class="row" id="' + i + '"><div class="col">' + (i + 1) + '</div>';
            for (let j = 0; j < this.alias.length; j++) {
                table += '<div class="col">' + this.result[i][this.alias[j]] + '</div>';
            }
            for (let j = 0; j < this.functionCalls.length; j++) {
                let functionObj = {
                    result: this.result[i],
                    pActive: this.pActive
                };
                table += '<div class="col" id="' + this.functionCalls[j] + '"><button onclick=\'' + this.functionCalls[j] + '.apply(' + JSON.stringify(functionObj) + ')\'>' + this.buttonName + '</button></div>';
            }
            table += '</div>'
        }
        jq351(this.id).append(table);
    }
}