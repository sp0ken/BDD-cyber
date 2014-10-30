function getParameterByName(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(window.location.search);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(document).ready(function() {

  $('#urbicande_persobundle_groupetype_members').children('option[value="'+getParameterByName('perso')+'"]').attr('selected', 'selected');
  $('#urbicande_chronobundle_eventtype_players').children('option[value="'+getParameterByName('perso')+'"]').attr('selected', 'selected');
  $('#urbicande_chronobundle_scenotype_intrigue').children('option[value="'+getParameterByName('intrigue')+'"]').attr('selected', 'selected');

  $('.button:not(input[type="submit"])').on('click', function(){
    window.location = $(this).find('a').attr('href');
  });

  //Activating rich text editor
  $('.rte').redactor({
    lang: 'fr',
    plugins: ['fullscreen'], 
  });

  //jQuery multiselect initialization
  $('select[multiple="multiple"]').chosen({
    placeholder_text_multiple: 'Selectionner des options',
    disable_search_threshold: 8,
    no_results_text: 'Pas de résultat'
  })

  //jQuery datatables initialization
  TableTools.DEFAULTS.aButtons = [
    { 
      "sExtends": "print", 
      "sButtonText": "Imprimer",
      "sButtonClass": "hide-for-medium-down"
    }, 
    {
      "sExtends": "collection", 
      "sButtonText": "Sauvegarder", 
      "sButtonClass": "hide-for-medium-down",
      "aButtons":    [ "csv", "xls", "pdf" ]
    }
  ];
  TableTools.DEFAULTS.sSwfPath = "/swf/copy_csv_xls_pdf.swf";

  $('.datatable').dataTable({
    "bPaginate": false,
    "bLengthChange": false,
    "bStateSave": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": false,
    "bAutoWidth": false,
    "aaSorting": [ [0,'asc'], [1,'asc'] ],
    "sDom": '<"left"T>Rl<"hide-for-small"f>rtip',
    "oLanguage": {
      "sProcessing":     "Traitement en cours...",
      "sSearch":         "Rechercher&nbsp;:",
      "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
      "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix":    "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable":     "Aucune donnée disponible dans le tableau",
      "oPaginate": {
          "sFirst":      "Premier",
          "sPrevious":   "Pr&eacute;c&eacute;dent",
          "sNext":       "Suivant",
          "sLast":       "Dernier"
      },
      "oAria": {
          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
      }
    },
  });

  //jQuery fullcalendar initialization
  $('#calendar').fullCalendar({
    'height': 400,
    'header': false,
    'allDaySlot': false,
    'defaultView': 'agendaWeek',
    'firstHour': 10,
    'defaultEventMinutes': 30,
    'timeFormat': 'H:mm',
    'axisFormat': 'H:mm',
    'monthNames': ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
    'monthNamesShort': ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"],
    'dayNames': ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
    'dayNamesShort': ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
    'events': $('#calendar').attr("data-urbi-url"),
    dayClick: function(date, allDay, jsEvent, view) {
        $('#calendar').fullCalendar('gotoDate', date);
        $('#calendar').fullCalendar('changeView', 'agendaDay');
      },
  })

  //Adding points to caracteristic on homepage
  $('#rpg li a').on('click', function(event){
    event.preventDefault();
    var value = $(this).parent().children('.point');
    var total = parseInt($('.total').html());
    if(total == 1 ) $('#rpg li a').remove();
    $.ajax({
      url: $(this).attr('data-url'),
      type: 'GET',
      context: value,
      data: {carac: $(this).attr('data-carac')},
      complete: function(xhr, textStatus) {
        if(parseInt($('.total').html()) === 0) $('.total').parent().remove();
      },
      success: function(data, textStatus, xhr) {
        var current = parseInt($(this).html());
        $(this).html(current+1);
        $('.total').html(total-1);
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
      }
    });
    
  });

  var dataHolder = $('div.datas');
  var ruleHolder = $('div.rules');
  var timingHolder = $('div.timings');
  var implicationHolder = $('div.implications');

  // setup an "add a..." link
  var $addDataLink = $('<a href="#" class="add_data_link">Ajouter une donnée objective</a>');
  var $addRuleLink = $('<a href="#" class="add_implication_link">Ajouter une règle</a>');
  var $addTimingLink = $('<a href="#" class="add_timing_link">Ajouter un timing</a>');
  var $addImplicationLink = $('<a href="#" class="add_implication_link" data-urbi-perso="'+getParameterByName('perso')+'">Ajouter une implication</a>');
  var $newDataLink = $('<div class=""></div>').append($addDataLink);
  var $newRuleLink = $('<div class=""></div>').append($addRuleLink);
  var $newTimingLink = $('<div class=""></div>').append($addTimingLink);
  var $newImplicationLink = $('<div class=""></div>').append($addImplicationLink);
  

  // add the "add a" anchor and li to the tags ul
  dataHolder.append($newDataLink);
  ruleHolder.append($newRuleLink);
  timingHolder.append($newTimingLink);
  implicationHolder.append($newImplicationLink);
  
  $addDataLink.on('click', function(e) {
      // prevent the link from creating a "#" on the URL
      e.preventDefault();

      // add a new tag form (see next code block)
      addTagForm(dataHolder, $newDataLink);
      $('select[multiple="multiple"]').multiselect({
        noneSelectedText: 'Selectionner des options',
        checkAllText: 'Tous',
        uncheckAllText: 'Aucun',
        selectedList: 4,
      });
      
      $('.rte').wysiwyg({
        'initialContent': 'À toi de le remplir',
        'resizeOptions': {},
        'autoGrow': true,
        'autoSave': true,
        'iFrameClass' : 'iframe-rte',
        'controls': {
          html: { visible: true }
        }
      });
  });

  $addImplicationLink.on('click', function(e) {
      // prevent the link from creating a "#" on the URL
      e.preventDefault();

      // add a new tag form (see next code block)
      addTagForm(implicationHolder, $newImplicationLink);
      if(implicationHolder.children().length == 2) {
        $('#urbicande_intriguebundle_intriguetype_implications_1_player').children('option[value="'+$(this).attr('data-urbi-perso')+'"]').attr('selected', 'selected');
      }
      $('.rte').wysiwyg({
        'initialContent': 'À toi de le remplir',
        'resizeOptions': {},
        'autoGrow': true,
        'autoSave': true,
        'iFrameClass' : 'iframe-rte',
        'controls': {
          html: { visible: true }
        }
      });
  });

  $addTimingLink.on('click', function(e) {
      // prevent the link from creating a "#" on the URL
      e.preventDefault();

      // add a new tag form (see next code block)
      addTagForm(timingHolder, $newTimingLink);
      $('.rte').wysiwyg({
        'initialContent': 'À toi de le remplir',
        'resizeOptions': {},
        'autoGrow': true,
        'autoSave': true,
        'iFrameClass' : 'iframe-rte',
        'controls': {
          html: { visible: true }
        }
      });
  });

  $addRuleLink.on('click', function(e) {
      // prevent the link from creating a "#" on the URL
      e.preventDefault();

      // add a new tag form (see next code block)
      addTagForm(ruleHolder, $newRuleLink);
      $('.rte').wysiwyg({
        'initialContent': 'À toi de le remplir',
        'resizeOptions': {},
        'autoGrow': true,
        'autoSave': true,
        'iFrameClass' : 'iframe-rte',
        'controls': {
          html: { visible: true }
        }
      });
  });

  drawVisualization();
});

function addTagForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '$$name$$' in the prototype's HTML to
    // instead be a number based on the current collection's length.
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div class="twelve columns block"></div>').append(newForm);
    $newLinkLi.before($newFormLi);
}