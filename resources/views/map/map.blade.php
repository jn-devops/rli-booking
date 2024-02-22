<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>RLI - Map View</title>

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
            /*.esri-popup__main-container {
                max-height: 600px;
              } */
        </style>
      <link rel="stylesheet" href="https://js.arcgis.com/4.28/esri/themes/light/main.css">
      <script src="https://js.arcgis.com/4.28/"></script>

      <script>
        var request = @json($request);

        require([
            "esri/config",
            "esri/Map",
            "esri/views/MapView",
            "esri/layers/FeatureLayer",
            "esri/renderers/UniqueValueRenderer",
            "esri/symbols/SimpleFillSymbol",
            "esri/symbols/SimpleLineSymbol",
            "esri/popup/content/MediaContent"
        ], function(esriConfig, Map, MapView, FeatureLayer) {

        esriConfig.apiKey = "AAPKbb1ec31993bc4b53a4561f7a92ec0f93fsCodiuTnhs0UTa1VHfVhKIkCj2sg2Z1aLmCrqdyKt_XsLsouJLDRKIJbVfqicEQ";

        const skuParam = request.sku;
        const voucherNumParam = request.voucher_number;
        const orderNumParam = request.property_code;

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
          basemap: "arcgis/topographic"
        });

        const view = new MapView({
            container: "viewDiv",
            map: map,
            center: [121.099711, 14.194851],
            zoom: 18,
        });

        const popupTrailheads = {
            title : "{PROPERTY_C}",
            content: [
                {
                // Add media content for the image
                type: "media",
                mediaInfos: [{
                  title: "",
                  caption: "",
                  type: "image",
                  value: {
                    sourceURL: "{IMAGE}"
                  }
                }]
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
                    fieldName: "STATUS",
                    label: "Status"
                  },
                  {
                    fieldName: "SKU",
                    label: "SKU"
                  },
                  // Add other fieldInfos as needed
                ]
              }
            ]
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
          url: "https://services8.arcgis.com/otYxeEfDBekePP4u/arcgis/rest/services/Agapeya_Pol_ExportFeatures/FeatureServer",
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
            "title": "{PROPERTY_C}",
            "content": "<b>Project Code:</b> {N___PROJEC}<br><b>Block:</b> {BLOCK}<br><b>Lot:</b> {Lot}<br><b>Lot Area:</b> {LOT_AREA} SQM<br><b>Floor Area:</b> {FLOOR_AREA} SQM<br><b>Status:</b> {STATUS}<br><b>SKU:</b> {SKU}<br><b><a href='https://book-dev.enclaves.ph/edit-order/"+voucherNumParam+"/"+orderNumParam+"/{PROPERTY_C}'>SELECT THIS PROPERTY</a></b>"
          };

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
          url: "https://services8.arcgis.com/otYxeEfDBekePP4u/arcgis/rest/services/Agapeya_Line_Layer/FeatureServer"
        });

        map.add(lineLayer, 0);

        let whereClause = "";

        if (skuParam != null) {
          whereClause = "Sku = '"+skuParam+"' and Status = 1";
          queryFeatureLayer(view.extent);

          // const trailheadsLayer = new FeatureLayer({
          //   url: "https://services8.arcgis.com/otYxeEfDBekePP4u/arcgis/rest/services/Agapeya_Pol/FeatureServer",
          //   outFields: ["BLOCK","FLOOR_AREA","LOT","LOT_AREA","N___PROJEC","PROPERTY_C","STATUS"],
          //   popupTemplate: popupTrailheads,
          //   renderer: openSpacesRenderer,
          //   opacity: .35
          // });

        } else {

          const trailheadsLayer = new FeatureLayer({
            url: "https://services8.arcgis.com/otYxeEfDBekePP4u/arcgis/rest/services/Agapeya_Polygon_Layer/FeatureServer",
            outFields: ["*"],
            popupTemplate: popupTrailheads,
            renderer: openSpacesRenderer,
            opacity: .35
          });

          map.add(trailheadsLayer);

        }

        });
        </script>

    </head>
    <body class="font-sans antialiased">
        <div id="viewDiv"></div>
    </body>
</html>
