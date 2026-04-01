//[custom Javascript]
//Project:	Compass - Responsive Bootstrap 4 Template
//Version:  1.0
//Last change:  15/12/2017
//Primary use:	Compass - Responsive Bootstrap 4 Template
//should be included in all pages. It controls some layout
$(function() {
    "use strict";
    initSparkline();
    MorrisArea();
    Jknob();
});

// Start
function initSparkline() {
    $(".sparkline").each(function() {
        var $this = $(this);
        $this.sparkline('html', $this.data());
    });
}
//End
//Start


//Start
function MorrisArea() {
   
    Morris.Area({
        element: 'm_area_chart2',
        data: [{
            period: '2012',
            SiteA: 10,
            SiteB: 0,
    
        }, {
            period: '2013',
            SiteA: 105,
            SiteB: 110,
    
        }, {
            period: '2014',
            SiteA: 78,
            SiteB: 92,
    
        }, {
            period: '2015',
            SiteA: 89,
            SiteB: 185,
    
        }, {
            period: '2016',
            SiteA: 175,
            SiteB: 149,
    
        }, {
            period: '2017',
            SiteA: 126,
            SiteB: 98,
    
        }],
        xkey: 'period',
        ykeys: ['SiteA', 'SiteB'],
        labels: ['Site A', 'Site B'],
        pointSize: 0,
        fillOpacity: 0.4,
        pointStrokeColors: ['#b6b8bb', '#a890d3'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 0,
        smooth: false,
        hideHover: 'auto',
        lineColors: ['#b6b8bb', '#a890d3'],
        resize: true
    
    });
}
//End
//Start
function Jknob() {
    $('.knob').knob({
        draw: function() {
            // "tron" case
            if (this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv) // Angle
                    ,
                    sa = this.startAngle // Previous start angle
                    ,
                    sat = this.startAngle // Start angle
                    ,
                    ea // Previous end angle
                    , eat = sat + a // End angle
                    ,
                    r = true;

                this.g.lineWidth = this.lineWidth;

                this.o.cursor &&
                    (sat = eat - 0.3) &&
                    (eat = eat + 0.3);

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value);
                    this.o.cursor &&
                        (sa = ea - 0.3) &&
                        (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.previousColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });
}
//End
//Start
$(window).on('scroll',function() {
    $('.card .sparkline').each(function() {
        var imagePos = $(this).offset().top;

        var topOfWindow = $(window).scrollTop();
        if (imagePos < topOfWindow + 400) {
            $(this).addClass("pullUp");
        }
    });
});
//End
//Start



//End
//Start
$(function() {
    $('#world-map-markers').vectorMap({
        map: 'world_mill_en',
        normalizeFunction: 'polynomial',
        hoverOpacity: 0.7,
        hoverColor: false,
        zoomOnScroll:false,
        backgroundColor: 'transparent',
        regionStyle: {
            initial: {
                fill: '#49cdd0',
                "fill-opacity": 1,
                stroke: 'none',
                "stroke-width": 0,
                "stroke-opacity": 1
            },
            hover: {
                fill: 'rgba(255, 193, 7, 2)',
                cursor: 'pointer'
            },
            selected: {
                fill: 'red'
            },
            selectedHover: {}
        },
        focusOn: {
            region: 'IN',
            animate: true
        },
        markerStyle: {
            initial: {
                fill: '#fff',
                stroke: '#FFC107',                
            }
        },
        markers: [{
                latLng: [28.7041, 77.1025],
                name: 'Delhi'
            },
            {
                latLng: [12.9716, 77.5946],
                name: 'Banglore'
            },
            {
                latLng: [28.4595, 77.0266],
                name: 'Gurugram'
            },
            {
                latLng: [19.0760, 72.8777],
                name: 'Mumbai'
            },
            {
                latLng: [28.5355, 77.3910],
                name: 'Noida'
            },
            {
                latLng: [28.9845, 77.7064],
                name: 'Merrut'
            },
        ]
    });
});
//End

