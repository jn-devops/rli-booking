<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Raemulan Lands Inc - Agapeya</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            html, body, #viewDiv {
              padding: 0;
              margin: 0;
              height: 100%;
              width: 100%;
            }

            #basemapStyles {
              width: 250px;
              padding: 10px;
            }
            .hide{
              display: none;
            }
            table {
              font-family: Arial, sans-serif;
              border-collapse: collapse;
              width: 100%;
            }

            th, td {
              border: 1px solid #dddddd;
              text-align: left;
              padding: 8px;
            }

            .media {
              display: block;
              margin-left: auto;
              margin-right: auto;
              max-width: 100%;
              height: auto;
            }

            .select-property {
              text-align: center;
            }

            .hidden {
              display: none;
            }
        </style>
      <link rel="stylesheet" href="https://js.arcgis.com/4.29/esri/themes/dark/main.css">
      <script src="https://js.arcgis.com/4.29/"></script>

      <script type="module" src="https://js.arcgis.com/calcite-components/2.5.1/calcite.esm.js"></script>
      <link rel="stylesheet" type="text/css" href="https://js.arcgis.com/calcite-components/2.5.1/calcite.css" />

      <script>
        var request = @json($request);
        var baseUrl = "{{ env('BASE_URL') }}";
        var apiKey = "{{ env('ARC_GIS_KEY') }}";
        var polygonLayerEnv = "{{ env('AGAPEYA_POLYGON_LAYER') }}";
        var lineLayerEnv = "{{ env('AGAPEYA_LINE_LAYER') }}";

        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",
            "esri/layers/FeatureLayer",
            "esri/widgets/Home",
            "esri/widgets/Search",
            "esri/renderers/UniqueValueRenderer",
            "esri/symbols/SimpleFillSymbol",
            "esri/symbols/SimpleLineSymbol",
            "esri/popup/content/MediaContent",
        ], function(esriConfig, Map, MapView, FeatureLayer, Home, Search) {

        esriConfig.apiKey = apiKey;

        const skuParam = request.sku;
        const voucherNumParam = request.voucher_number;
        const orderNumParam = request.property_code;

        // var basemapDropdown = document.getElementById("basemap-select");
        // basemapDropdown.addEventListener("change", changeBasemap);

        // function changeBasemap(event){
        //   var newBasemap = basemapDropdown.value;
        //   view.map.basemap = newBasemap;
        // }

        const labelClass = { // autocasts as new LabelClass()
            symbol: {
              type: "text", // autocasts as new TextSymbol()
              color: "white",
              haloColor: "black",
              font: { // autocast as new Font()
                family: "playfair-display",
                size: 12,
                weight: "bold"
              }
            },
            labelPlacement: "above-center",
            labelExpressionInfo: {
              expression: "$feature.LOT"
            }
        };

        const map = new Map({
          basemap: "osm/hybrid"
        });

        const view = new MapView({
            container: "viewDiv",
            map: map,
            center: [121.099711, 14.194851],
            zoom: 18,
            popup: {
            dockEnabled: true,
            dockOptions: {
                breakpoint: false,
                position: "top-right"
              }
            },
        });


        const updateBasemapStyle = (basemapId) => {
          view.map.basemap = basemapId;
        };

        const basemapStylesDiv = document.getElementById("basemapStyles");
        view.ui.add(basemapStylesDiv, "top-right");

        const styleCombobox = document.getElementById("styleCombobox");
        styleCombobox.addEventListener("calciteComboboxChange", (event) => {
          updateBasemapStyle(event.target.value);
        });

        const homeBtn = new Home({
          view: view
        });

        const searchWidget = new Search({
          view: view,
        });

        view.ui.add(searchWidget, {
          position: "top-left",
          index: 0
        });


        const popupTrailheads = {
          title : "{PROPERTY_C}",
          content: function (feature) {
            console.log(feature.graphic.attributes);

            const IMAGE  = ( feature.graphic.attributes.IMAGE ? feature.graphic.attributes.IMAGE : "https://placehold.co/600x400");
            const PROJECT_CO  = feature.graphic.attributes.PROJECT_CO;
            const BLOCK  = feature.graphic.attributes.BLOCK;
            const LOT  = feature.graphic.attributes.LOT;
            const TCP_DUPLEX  = feature.graphic.attributes.TCP_DUPLEX;
            const LOT_AREA  = feature.graphic.attributes.LOT_AREA;
            const FLOOR_AREA  = ( feature.graphic.attributes.FLOOR_AREA ? feature.graphic.attributes.FLOOR_AREA : "");
            const STATUS  = ( feature.graphic.attributes.STATUS ? "Available" : "Not Available");
            const PROPERTY_C  = feature.graphic.attributes.PROPERTY_C;
            const SKU  = ( feature.graphic.attributes.SKU ? feature.graphic.attributes.SKU : "");
            const hide  = ( ((feature.graphic.attributes.STATUS && voucherNumParam) && (skuParam == SKU)) ? "" : "hide");

            const div = document.createElement("div");
            div.innerHTML =
              `<div><img style="width:100%" src="${IMAGE}" alt="Media Image"></div><table><tbody><tr><th>Project Code</th><td>${PROJECT_CO}</td></tr><tr><th>Block</th><td>${BLOCK}</td></tr><tr><th>Lot</th><td>${LOT}</td></tr><tr><th>Selling Price</th><td>${TCP_DUPLEX}</td></tr><tr><th>Lot Area</th><td>${LOT_AREA}</td></tr><tr><th>Floor Area</th><td>${FLOOR_AREA}</td></tr><tr><th>Status</th><td>${STATUS}</td></tr><tr><th>SKU</th><td>${SKU}</td></tr><tr><td colspan="2" class="select-property"><b><a style="color:white;cursor:pointer" target="_self" class="${hide}" href="${baseUrl}/edit-order/${voucherNumParam}/${orderNumParam}/${PROPERTY_C}">SELECT THIS PROPERTY</a></b></td></tr></tbody></table>`;
            return div;
          }
        }

        // Add parks with a class breaks renderer and unique symbols
        function createFillSymbol(value, color) {
          return {
            "value": value,
            "symbol": {
              "color": color,
              "type": "simple-fill",
              "style": "solid",
              "outline": {
                "style": "none"
              }
            },
            "label": value
          };
        }

        const openSpacesRenderer = {
          field: "COLOR",
          type: "unique-value",
          uniqueValueInfos: [
            createFillSymbol("GREEN", "GREEN"),
            createFillSymbol("YELLOW", "YELLOW"),
            createFillSymbol("PURPLE", "PURPLE"),
            createFillSymbol("PINK", "PINK"),
            createFillSymbol(" ", "GRAY"),
          ]
        };

        // const availableSpacesRenderer = {
        //   field: "STATUS",
        //   type: "unique-value",
        //   uniqueValueInfos: [
        //     createFillSymbol("1", "GREEN"),
        //     createFillSymbol("0", "GRAY"),
        //   ]
        // };

        const availableSpacesRenderer = {
          type: "unique-value",
          valueExpression: "When($feature.STATUS > 0 && $feature.SKU == '"+skuParam+"', 'available', 'not_available')",
          uniqueValueInfos: [
            {
              value: "available",
              symbol: {
                type: "simple-fill",
                color: "green"
              }
            },
            {
              value: "not_available",
              symbol: {
                type: "simple-fill",
                color: "gray"
              }
            }
          ]
        };

        

        // SELECT STATUS EVENT TRIGGER 
        // SQL query array
        // const parcelLayerSQL = ["Choose a SQL where clause...", "Status = '1'",  "Status = '0'"];
        // let whereClause = parcelLayerSQL[0];

        // // Add SQL UI
        // const select = document.createElement("select");
        // select.setAttribute("class", "esri-widget esri-select");
        // select.setAttribute("style", "width: 200px; font-family: 'Avenir Next'; font-size: 1em");
        // parcelLayerSQL.forEach(function(query){
        //   let option = document.createElement("option");
        //   option.innerHTML = query;
        //   option.value = query;
        //   select.appendChild(option);
        // });

        // view.ui.add(select, "top-right");

        // // Listen for changes
        // select.addEventListener('change', (event) => {
        //   whereClause = event.target.value;
        //   // Status = '1'
        //   queryFeatureLayer(view.extent);
        // });

        // Get query layer and set up query
        const parcelLayer = new FeatureLayer({
          url: polygonLayerEnv,
          labelingInfo: [labelClass],
        });

        function queryFeatureLayer(extent) {

          const parcelQuery = {
           where: whereClause,  // Set by select element
           spatialRelationship: "intersects", // Relationship operation to apply
           geometry: extent, // Restricted to visible extent of the map
           outFields: ["*"], // Attributes to return
           returnGeometry: true
          };

          parcelLayer.queryFeatures(parcelQuery)

          .then((results) => {

            console.log("Feature count: " + results.features.length)

            displayResults(results);

          }).catch((error) => {
            console.log(error.error);
          });
        }

        function displayResults(results) {
          // Create a blue polygon
          const symbol = {
            type: "simple-fill",
            color: "GREEN",
            outline: {
              color: "white",
              width: .5
            },
          };

          const popupTemplate = {
            title: "{PROPERTY_C}",
            content: [
              {
                // Add media content for the image
                type: "media",
                mediaInfos: [
                  {
                    title: "",
                    caption: "",
                    type: "image",
                    value: {
                      sourceURL: "{IMAGE}" // Replace {IMAGE} with the appropriate field name for the image
                    }
                  }
                ]
              },
              {
                type: "fields",
                fieldInfos: [
                  {
                    fieldName: "N___PROJEC",
                    label: "Project Code",
                    format: {
                      digitSeparator: true,
                      places: 0
                    }
                  },
                  {
                    fieldName: "BLOCK",
                    label: "Block"
                  },
                  {
                    fieldName: "Lot",
                    label: "Lot"
                  },
                  {
                    fieldName: "TCP_DUPLEX",
                    label: "Selling Price",
                    format: {
                      digitSeparator: true,
                      places: 2
                    }
                  },
                  {
                    fieldName: "LOT_AREA",
                    label: "Lot Area",
                    format: {
                      digitSeparator: true,
                      places: 2
                    }
                  },
                  {
                    fieldName: "FLOOR_AREA",
                    label: "Floor Area",
                    format: {
                      digitSeparator: true,
                      places: 2
                    }
                  },
                  {
                    fieldName: "COLOR",
                    label: "Color",
                  },
                  {
                    fieldName: "ORIENTATIO",
                    label: "Orientation",
                  },
                  // {
                  //   fieldName: "STATUS",
                  //   label: "Status",
                  //   format: {
                  //     custom: formatStatus
                  //   }
                  // },
                  {
                    fieldName: "SKU",
                    label: "SKU"
                  }
                  // Add other fieldInfos as needed
                ]
              },
              {
                type: "text",
                text: `<b><a target="_self" href='${baseUrl}/edit-order/${voucherNumParam}/${orderNumParam}/{PROPERTY_C}'>SELECT THIS PROPERTY</a></b>`
              }
            ]
          };

          function formatStatus(value) {
            return value === 1 ? "Available" : "Unavailable";
          }

          // voucherNumParam
          // orderNumParam

          // Assign styles and popup to features
          results.features.map((feature) => {
            feature.symbol = symbol;
            feature.popupTemplate = popupTemplate;
            return feature;
          });

          // Clear display
          view.closePopup();
          view.graphics.removeAll();

          // Add features to graphics layer
          view.graphics.addMany(results.features);
        }

        const lineLayer = new FeatureLayer({
          url: lineLayerEnv,
          renderer: {
            type: "simple",
            symbol: {
              type: "simple-line",
              color: [0, 0, 0], // Change this RGB value to set the line color (black in this case)
              width: 2 // Change this value to set the line width
            }
          }
        });

        map.add(lineLayer, 0);

        let whereClause = "";

        if (skuParam != null) {
          // whereClause = "Sku LIKE '%"+skuParam+"%' and Status = 1";
          // queryFeatureLayer(view.extent);

          const trailheadsLayer = new FeatureLayer({
            url: polygonLayerEnv,
            outFields: ["*"],
            popupTemplate: popupTrailheads,
            renderer: availableSpacesRenderer,
            opacity: .8
          });

          map.add(trailheadsLayer);

          // const trailheadsLayer = new FeatureLayer({
          //   url: "https://services8.arcgis.com/otYxeEfDBekePP4u/arcgis/rest/services/Agapeya_Pol/FeatureServer",
          //   outFields: ["BLOCK","FLOOR_AREA","LOT","LOT_AREA","N___PROJEC","PROPERTY_C","STATUS"],
          //   popupTemplate: popupTrailheads,
          //   renderer: openSpacesRenderer,
          //   opacity: .5
          // });

        } else {

          const trailheadsLayer = new FeatureLayer({
            url: polygonLayerEnv,
            outFields: ["*"],
            popupTemplate: popupTrailheads,
            renderer: openSpacesRenderer,
            opacity: .75
          });

          map.add(trailheadsLayer);

        }

         view.ui.add(homeBtn, "top-left");

        });
        </script>

    </head>
    <body class="font-sans antialiased">
        <div id="viewDiv"></div>
         <div id="basemapStyles" class="esri-widget">
          <calcite-label>Basemap style</calcite-label>
          <calcite-combobox id="styleCombobox" selection-mode="single" clear-disabled>
            <calcite-combobox-item value="arcgis/navigation" text-label="arcgis/navigation"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/navigation-night" text-label="arcgis/navigation-night"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/streets" text-label="arcgis/streets"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/streets-relief" text-label="arcgis/streets-relief"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/streets-night" text-label="arcgis/streets-night"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/outdoor" text-label="arcgis/outdoor"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/imagery" text-label="arcgis/imagery"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/topographic" text-label="arcgis/topographic" ></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/terrain" text-label="arcgis/terrain"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/oceans" text-label="arcgis/oceans"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/light-gray" text-label="arcgis/light-gray"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/dark-gray" text-label="arcgis/dark-gray"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/human-geography" text-label="arcgis/human-geography"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/human-geography-dark" text-label="arcgis/human-geography-dark"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/charted-territory" text-label="arcgis/charted-territory"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/colored-pencil" text-label="arcgis/colored-pencil"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/nova" text-label="arcgis/nova"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/modern-antique" text-label="arcgis/modern-antique"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/midcentury" text-label="arcgis/midcentury"></calcite-combobox-item>
            <calcite-combobox-item value="arcgis/newspaper" text-label="arcgis/newspaper"></calcite-combobox-item>
            <calcite-combobox-item value="osm/standard" text-label="osm/standard"></calcite-combobox-item>
            <calcite-combobox-item value="osm/standard-relief" text-label="osm/standard-relief"></calcite-combobox-item>
            <calcite-combobox-item value="osm/navigation" text-label="osm/navigation"></calcite-combobox-item>
            <calcite-combobox-item value="osm/navigation-dark" text-label="osm/navigation-dark"></calcite-combobox-item>
            <calcite-combobox-item value="osm/streets" text-label="osm/streets"></calcite-combobox-item>
            <calcite-combobox-item value="osm/hybrid" text-label="osm/hybrid" selected></calcite-combobox-item>
            <calcite-combobox-item value="osm/light-gray" text-label="osm/light-gray"></calcite-combobox-item>
            <calcite-combobox-item value="osm/dark-gray" text-label="osm/dark-gray"></calcite-combobox-item>
            <calcite-combobox-item value="osm/blueprint" text-label="osm/blueprint"></calcite-combobox-item>
          </calcite-combobox>
        </div>
    </body>
</html>