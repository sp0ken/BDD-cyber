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

function createTask(url) {
  var writer = document.getElementById('urbicande_miscbundle_tasktype_writer');
  var text = document.getElementById('urbicande_miscbundle_tasktype_text');
  var endDay = document.getElementById('urbicande_miscbundle_tasktype_endDate_day');
  var endMonth = document.getElementById('urbicande_miscbundle_tasktype_endDate_month');
  var endYear = document.getElementById('urbicande_miscbundle_tasktype_endDate_year');

  $.ajax({
    url: url,
    data: {writer: writer.value, text: text.value, endDay: endDay.value, endMonth: endMonth.value, endYear: endYear.value},
  })
  .done(function(data, textStatus, xhr) {
    console.log("success");
    console.log(data);
    $('#my-tasks ul').append('<li><a href="#"><i class="fa fa-square-o"></i> '+data.tache+' </a></li>')
    $('#task').foundation('reveal', 'close');
  })
  .fail(function(data, textStatus, xhr) {
    console.log("error");
    console.log(data);
  });
  
}

function resize(id, action, url) {
  var blockToResize = $('#'+id).parent();
  var oldSize = blockToResize.attr('data-size');
  var newSize = blockToResize.attr('data-size');
  switch(oldSize) {
    case 'medium-12':
        newSize = (action == 'larger') ? 'medium-12' : 'medium-10'
        break;
    case 'medium-10':
        newSize = (action == 'larger') ? 'medium-12' : 'medium-9'
        break;
    case 'medium-9':
        newSize = (action == 'larger') ? 'medium-10' : 'medium-6'
        break;
    case 'medium-6':
        newSize = (action == 'larger') ? 'medium-9' : 'medium-4'
        break;
    case 'medium-4':
        newSize = (action == 'larger') ? 'medium-6' : 'medium-3'
        break;
    case 'medium-3':
        newSize = (action == 'larger') ? 'medium-4' : 'medium-2'
        break;
    case 'medium-2':
        newSize = (action == 'larger') ? 'medium-3' : 'medium-2'
        break;
  }
  blockToResize.attr('data-size', newSize);
  blockToResize.removeClass(oldSize).addClass(newSize);
  $(document).foundation('equalizer', 'reflow');
  $.ajax({
    url: url,
    data: {block: id, size: newSize.replace('medium-', '')},
  })
}

$(document).ready(function() {

  $('#urbicande_persobundle_groupetype_members').children('option[value="'+getParameterByName('perso')+'"]').attr('selected', 'selected');
  $('#urbicande_chronobundle_eventtype_players').children('option[value="'+getParameterByName('perso')+'"]').attr('selected', 'selected');

  $('.button:not(.popup):not(input[type="submit"]):not([href="#"])').on('click', function(){
    window.location = $(this).find('a').attr('href');
  });

  //Activating rich text editor
  $('.rte').redactor({
    lang: 'fr',
    plugins: ['fullscreen'], 
  });

  $('.rte').sisyphus();

  //jQuery multiselect initialization
  $('select[multiple="multiple"]').chosen({
    placeholder_text_multiple: 'Selectionner des options',
    disable_search_threshold: 8,
    no_results_text: 'Pas de résultat'
  })

  //jQuery datatables initialization

  $('.datatable').DataTable({
    "responsive": true,
    "searching": true,
    "stateSave": true,
    "ordering": true,
    "order": [[ 0, 'asc' ], [ 1, 'asc' ]],
    "paging": false,
    "info": false,
    "lengthChange": false,
    "autoWidth": false,
    "dom": 'Bfrtip>',
    buttons: [
        {
            extend:    'copy',
            text:      '<i class="fa fa-files-o"></i>',
            titleAttr: 'Copier'
        },
        {
            extend:    'excel',
            text:      '<i class="fa fa-file-excel-o"></i>',
            titleAttr: 'Excel'
        },
        {
            extend:    'csv',
            text:      '<i class="fa fa-file-text-o"></i>',
            titleAttr: 'CSV'
        },
        {
            extend:    'pdf',
            text:      '<i class="fa fa-file-pdf-o"></i>',
            titleAttr: 'PDF'
        },
        {
            extend:    'print',
            text:      '<i class="fa fa-print"></i>',
            titleAttr: 'Imprimer'
        }
    ],
    "language": {
      "processing":     "Traitement en cours...",
      "search":         "Rechercher&nbsp;:",
      "lengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
      "info":           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "infoEmpty":      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
      "infoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "infoPostFix":    "",
      "loadingRecords": "Chargement en cours...",
      "zeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "emptyTable":     "Aucune donnée disponible dans le tableau",
      "paginate": {
          "first":      "Premier",
          "previous":   "Pr&eacute;c&eacute;dent",
          "next":       "Suivant",
          "last":       "Dernier"
      },
      "aria": {
          "sortAscending":  ": activer pour trier la colonne par ordre croissant",
          "sortDescending": ": activer pour trier la colonne par ordre décroissant"
      },
      fixedHeader: {
        header: true,
        footer: false
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

  $('#my-tasks ul').on('click', 'li', function(event) {
    event.preventDefault();
    $.ajax({
      url: $(this).attr('data-url'),
      context: $(this)
    })
    .done(function(data, textStatus, xhr) {
      console.log("success");
      $(this).children('a').children('i').removeClass('fa-square-o').addClass('fa-check-square');
    })
    .fail(function(data, textStatus, xhr) {
      console.log("error");
      console.log(data);
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
      $('select[multiple="multiple"]').chosen({
        placeholder_text_multiple: 'Selectionner des options',
        disable_search_threshold: 8,
        no_results_text: 'Pas de résultat'
      })
      
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