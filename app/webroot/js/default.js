function initApplication() {
    initAjaxHRef("container");
    initNavigationHRef("container");
    initDialogs();
    setupSearchBox();
    if ($(window).width() >= 1480) {
      ajaxGet("RecipeLinkBox/Index", "recipeLinkBoxContainer");
    } 
    
    window.onpopstate = function (event) {
        if (event.state && event.state.target) {
            ajaxGet(event.state.action, event.state.target);
        } else {
            // Get us Home and refresh
            location.reload();
        }
    };
}

function ajaxGet(location, target) {
    target = (target === undefined) ? "content" : target;
    console.log("getting:" + location + " Target: " +target);
    $.get(location, function(data) {
        $("#" + target ).html(data);
        initAjaxHRef(target);
        initMoreActionsLink(target);
        initAjaxForms(target);
        initAjaxDeleteLinks(target);
    });
}

function ajaxNavigate(actionUrl, title, targetId) {
    if (history.pushState) {
        var stateObj = { target: targetId, action: actionUrl };
        history.pushState(stateObj, title, actionUrl);
        ajaxGet(actionUrl, targetId);
    } else {
        location.assign(actionUrl);
    }
    return false;
}

function initNavigationHRef(targetId) {
    var findQuery = (targetId === undefined) ? "#content .ajaxNavigationLink" : "#" + targetId + " .ajaxNavigationLink";
    $(findQuery).each(function(event) {
        var $targetItem = $(this);
        if (!$(this).is('a')) $targetItem = $(this).find("a");
        //console.log('Navigation ' + $targetItem.attr('href') + ", Title = " + $targetItem.text());
        $targetItem.click(function() {
            console.log("Navigation Push " + $(this).attr('href') + ", target: " + $(this).attr('targetId') + ", Title = " + $(this).text());
            $("#moreActionLinks").qtip('destroy', true);
            ajaxNavigate($(this).attr('href'), $(this).text(), $(this).attr('targetId'));
            return false;
        });
    });
}

function initAjaxHRef(targetId) {
    var findQuery = (targetId === undefined) ? "#content .ajaxLink" : "#" + targetId + " .ajaxLink";
    $(findQuery).each(function(event) {
        var $targetItem = $(this);
        if (!$(this).is('a')) $targetItem = $(this).find("a");
        //console.log('ajaxLink: ' + $targetItem.attr('href'));
        $targetItem.click(function() {
            //console.log("getting " + $(this).attr('href') + ", target: " + $(this).attr('targetId'));
            $("#moreActionLinks").qtip('destroy', true);
            
            var $targetItem = $("#" + $(this).attr('targetId'));
            if ($targetItem.hasClass('ui-dialog-content')) {
                $targetItem.dialog('open');
            }
            
            ajaxGet($(this).attr('href'), $(this).attr('targetId'));
            return false;
        });
    });
}

function initAjaxForms(targetId) {
    var findQuery = (targetId === undefined) ? "#content form" : "#" + targetId + " form";
    $(findQuery).each(function(event) {
        $(this).bind("submit", function (event) {
            $.ajax({
                async:true, 
                data:$(this).serialize(), 
                dataType:"html", 
                success:function (data, textStatus) {
                    $("#content").html(data);
                }, 
                type:"POST", 
                url:$(this).attr('action')
            });
            return false;});
    });
}

function initAjaxDeleteLinks(targetId) {
    var findQuery = (targetId === undefined) ? "#content .ajaxDeleteLink" : "#" + targetId + " .ajaxDeleteLink";
    $(findQuery).each(function() {
        $(this).click(function() {
            var confirmMessage = $(this).attr('deletemessage');
            if (confirm(confirmMessage)) {
                //console.log("getting " + $(this).attr('href') + ", target: " + $(this).attr('targetId'));
                ajaxGet($(this).attr('href'), $(this).attr('targetId'));
            }
            return false;
        });
    });
}

function initMoreActionsLink(targetId)
{
    var findQuery = (targetId === undefined) ? "#moreActionLinks" : "#" + targetId + " #moreActionLinks";
    $(findQuery).qtip({
        content: $('#moreActionLinksContent'),
        position: {
            my: 'top center',  // Position my top left...
            at: 'bottom center', // at the bottom right of...
            target: $('#moreActionLinks') // my target
        },
        style: {
            classes: 'qtip-rounder qtip-shadow',
            widget: true, // Use the jQuery UI widget classes
            def: true // Remove the default styling (usually a good idea, see below)  
        },
        show: {
            event: 'click',
            effect: function(offset) {
                $(this).slideDown(400); // "this" refers to the tooltip
            }
        },
        hide: {
            event: 'click',
            effect: function(offset) {
                $(this).slideUp(400); // "this" refers to the tooltip
            }
        }
    }).click(function() { return false; });
}

function initDialogs() {
    var findQuery =".dialog";
    $(findQuery).each(function() {
        $(this).dialog({
		autoOpen: false,
		title: $(this).attr("title"),
		modal: true,
		width: $(this).attr("width"),
                height: $(this).attr("height"),
		buttons: { 
                    "Save": function() { 
                        $(this).find(':submit').click(); 
                    },
                    "Close": function() { $(this).dialog('close'); } 
                }
	});
    });
}

function setupSearchBox() {
    showCancel();
    $('.cancelBtn').click(function()
    {
        console.log('time to clear');
        $(".cancelBtn").stop();
        $(".cancelBtn").fadeTo(500 , 0 );
        $('.searchTextBox').val('');
    });

    $('.searchTextBox').change(function()
    {
        showCancel();
    });
    $('.searchTextBox').keydown(function()
    {
        showCancel();
    });
    
    $('.searchTextBox').keyup(function()
    {
        showCancel();
    });
    
    $('.searchTextBox').change();
}

function showCancel() {
    var textBxContent = $(".searchTextBox").val();
    if (textBxContent) {
        $(".cancelBtn").fadeTo(500, 1 );
    } else {
        $(".cancelBtn").fadeTo(500, 0 );
    }
}


