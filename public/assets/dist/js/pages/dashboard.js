/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder: 'sort-highlight',
    connectWith: '.connectedSortable',
    handle: '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex: 999999
  });

  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  /* jQueryKnob */
  $('.knob').knob();

  /* Morris.js Charts */
  var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  var date = new Date();
  //Revenue chart Start
    var area = new Morris.Area({
      element: 'revenue-chart',
      data: [
        { m: ''+months[date.getMonth()]+' Q1', item1: 2666, item1: 2666 },
      ],
      xkey      : 'm',
      ykeys     : ['item1', 'item2'],
      labels    : ['Item 1', 'Item 2'],
      lineColors: ['#a0d0e0', '#3c8dbc'],
      hideHover : 'auto'
    });
  //Revenue chart End

  //Orders chart Start
    var line = new Morris.Line({
      element: 'orders-chart',
      data: [
        { y: '2011 Q1', item1: 2666 },
        { y: '2011 Q2', item1: 2778 },
        { y: '2011 Q3', item1: 4912 },
        { y: '2011 Q4', item1: 3767 },
        { y: '2012 Q1', item1: 6810 },
        { y: '2012 Q2', item1: 5670 },
        { y: '2012 Q3', item1: 4820 },
        { y: '2012 Q4', item1: 15073 },
        { y: '2013 Q1', item1: 10687 },
        { y: '2013 Q2', item1: 8432 }
      ],
      xkey             : 'y',
      ykeys            : ['item1'],
      labels           : ['Item 1'],
      lineColors       : ['#efefef'],
      lineWidth        : 2,
      hideHover        : 'auto',
      gridTextColor    : '#fff',
      gridStrokeWidth  : 0.4,
      pointSize        : 4,
      pointStrokeColors: ['#efefef'],
      gridLineColor    : '#efefef',
      gridTextFamily   : 'Open Sans',
      gridTextSize     : 10
    });
  //Orders chart End

  // Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    line.redraw();
  });
});