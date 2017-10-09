function getSelectMainPart(idName){
    var rr = '<select style="max-width:95% !important;width:95% !important;"'+' id="'+idName+'"'+'class="'+'targetSelected'+'"'+'>';
    return rr;
}

function getOptions(opts){
    var ret = {};
    for (var key in opts) {
        ret[key] = opts[key];
    }
    return ret;
}

function add_options()
{
    var theArray = arguments[0];
    var options = '';

    if(arguments.length > 1)
    {

        var valueToBeSelected = arguments[1];
        var selected = false;

        for (var key in theArray)
        {
            if (typeof theArray[key] !== 'function') {


                if (valueToBeSelected !== "" && key === valueToBeSelected) {
                    selected = true;
                    options += "<option selected value =\"" + key + "\">" + theArray[key] + "</option>";
                }
                else {
                    options += "<option value = \"" + key + "\">" + theArray[key] + "</option>";
                }
            }
        }
        if(!selected){
            options += "<option selected value =\"\"></option>";

        }
        return options;
    }
    else
    {
        for (var key in theArray)
        {
            options += "<option value = \""+key+"\">"+theArray[key]+"</option>";
        }
        return options;
    }
}
function makeidAlfaNumber(len)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < len; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

