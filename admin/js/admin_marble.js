var grid = $("#marble_grid").bootgrid({
    ajax: true,
    rowSelect: true,
    post: function ()
    {
      /* To accumulate custom parameter with the request object */
      return {
        id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
      };
    },
    
    url: "response.php",
    formatters: {
            "commands": function(column, row)
            {
                return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " +
                    "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.id + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
            }
        }
   })