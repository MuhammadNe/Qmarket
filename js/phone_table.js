
$("#phonebookGrid").jsGrid({
    
     width: "100%",

    onItemUpdating: function(args) {        
        previousItem = args.previousItem;
        console.log(previousItem);
    },
   
    autoload: true,
    selecting: true,
    editing: true,
    sorting: true,
    paging: true,
    pageSize: 15,
    //inserting: true,
   
     
    controller: {
        loadData: function (filter) {
            console.log("Load Data");
            return $.ajax({
                type: "POST",
                url: "DatabaseFacade.php",
                data: {"function": "LoadBook"}
            }).done(function(data) {

            });

        },
        insertItem: function (item) {
            return $.ajax({
                type: "POST",
                url: "DatabaseFacade.php",
                data: {
                    "function": "AddEntry",
                    "item": item
                }
            }).done(function (data) {               
                $("#phonebookGrid").jsGrid("loadData");               
                displayMessage(data);
            });

        },
        
        updateItem: function (item) {
            console.log("item : ", item);
            return $.ajax({
                type: "POST",
                url: "DatabaseFacade.php",
                data: {
                    "function": "EditEntry",
                    "item": item,
                    "previousItem": previousItem
                }
            }).done(function (data) {
                $("#phonebookGrid").jsGrid("loadData");
                displayMessage(data);
            });

        },
        deleteItem: function (item) {
            console.log("item : ", item);
            return $.ajax({
                type: "POST",
                url: "DatabaseFacade.php",
                data: {
                    "function": "DeleteEntry",
                    "item": item
                }
            }).done(function (data) {
                $("#phonebookGrid").jsGrid("loadData");
                displayMessage(data);
            });

        }
    },
    
    fields: [
        {name: "name", type: "text", title: "Name"},
        {name: "phoneNumber", type: "text", title: "Phone Number"},
        {name: "email", type: "text", title: "Email"},
        {
            type: "control",
            editButton: true,
            headerTemplate: function () {
                var grid = this._grid;
                var isInserting = grid.inserting;

                var $button = $("<input>").attr("type", "button")
                        .addClass([this.buttonClass, this.modeButtonClass, this.insertModeButtonClass].join(" "))
                        .on("click", function () {
                            isInserting = !isInserting;
                            grid.option("inserting", isInserting);
                        });

                return $button;

            }
        }
    ]

});

function reload(){
    $("#phonebookGrid").jsGrid("loadData");
}

function displayMessage(data) {
        
        if(data.code == '200') {
                    $("#phonebook_msg_success").html(data.result);
                    $("#phonebook_msg_success").show().delay(1500).fadeOut();
                } else {
                    $("#phonebook_msg_fail").html(data.result);
                    $("#phonebook_msg_fail").show().delay(1500).fadeOut();
                }
    }