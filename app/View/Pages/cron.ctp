<?php
    header( 'Content-type: text/html; charset=utf-8' );
    @ini_set('zlib.output_compression',0);
    @ini_set('implicit_flush',1);
    @ob_end_clean();

    Configure::write('debug', 0);

    $options = [
        "makenewstrains" => true,//disable to prevent new strains from being created
    ];

    $negativeeffects = ["Bad Taste", "Cough", "Dry Mouth", "Harsh", "Headache", "Lazy", "Red Eyes", "Talkative", "Weak"];
    $extradata = [//CAUTION: lift_effects and lift_symptoms values are inverted (so truevalue=100-value)
        "ace-valley-cbd" => [
            "lift_url" => "https://lift.co/strains/ace-valley-ace-valley-cbd",
            "lift_vendor" => "Ace Valley",
            "lift_thc" => "6.5",
            "lift_cbd" => "12.7",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_effects" => ["Calming" => 40, "Relaxed" => 45, "Happy" => 61.6667],
            "urls" => [
                "https://www.leafly.com/products/details/ace-valley-ace-valley-cbd-35g?q=ace-valley-cbd&cat=product",
                "https://www.leafly.com/products/details/ace-valley-ace-valley-cbd-70g?q=ace-valley-cbd&cat=product",
                "https://www.leafly.com/products/details/ace-valley-ace-valley-cbd-pre-roll-3-pack?q=ace-valley-cbd&cat=product"
            ]
        ],
        "ace-valley-sativa" => [
            "lift_url" => "https://lift.co/strains/ace-valley-ace-valley-sativa",
            "lift_vendor" => "Ace Valley",
            "lift_thc" => "17.4",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_effects" => ["Happy" => 66.6667],
            "urls" => [
                "https://www.leafly.com/products/details/ace-valley-ace-valley-sativa-35g?q=ace-valley-sativa&cat=product",
                "https://www.leafly.com/products/details/ace-valley-ace-valley-sativa-70g?q=ace-valley-sativa&cat=product",
                "https://www.leafly.com/products/details/ace-valley-ace-valley-sativa-pre-roll-3-pack?q=ace-valley-sativa&cat=product",
                "https://www.leafly.com/products/details/ace-valley-ace-valley-sativa-pre-roll-single?q=ace-valley-sativa&cat=product"
            ]
        ],
        "airplane-mode" => [
            "lift_url" => "https://lift.co/strains/altavie-airplane-mode",
            "lift_vendor" => "Altavie",
            "lift_thc" => "16",
            "lift_cbd" => "0",
            "lift_des" => "A classic Kush that's earthy and woodsy on the nose, Airplane Mode is made up of compact, light green buds weaved with the occasional vibrant orange hair. Each dried flower is trimmed, sorted, and hang dried for a carefully crafted and hand-selected product.",
            "lift_flavors" => "",
            "lift_effects" => [],
            "urls" => ["https://www.leafly.com/products/details/altavie-airplane-mode?q=airplane-mode&cat=product"]
        ],
        "alien-dawg" => [
            "lift_url" => "https://lift.co/strains/aphria-inc-alien-dawg",
            "lift_vendor" => "Aphria Inc.",
            "lift_thc" => "24",
            "lift_cbd" => "0.1",
            "lift_des" => "",
            "lift_flavors" => "earthy, pungent, woody",
            "lift_effects" => ["Lazy" => 28.3333, "Red Eyes" => 36.6667, "Cough" => 45],
            "lift_symptoms" => ["Mood" => 30, "Appetite" => 41.6667, "Back Pain" => 41.6667, "Muscle Spasms" => 46.6667, "Headaches" => 48.3333],
            "urls" => [
                "https://www.leafly.com/products/details/nebula-gardens-alien-dawg?q=alien-dawg&cat=product",
                "https://www.leafly.com/products/details/silverpeak-alien-dawg?q=alien-dawg&cat=product",
                "https://www.leafly.com/products/details/kynd-cannabis-company-alien-dawg?q=alien-dawg&cat=product",
                "https://www.leafly.com/products/details/kynd-cannabis-company-alien-dawg-1g-pure-syringe?q=alien-dawg&cat=product",
                "https://www.leafly.com/products/details/kynd-cannabis-company-alien-dawg-1g-co2-dab-sap?q=alien-dawg&cat=product",
                "https://www.leafly.com/products/details/kynd-cannabis-company-alien-dawg-250mg-disposable-vape-pen?q=alien-dawg&cat=product"
            ]
        ],
        "argyle" => [
            "lift_url" => "https://lift.co/strains/tweed-argyle",
            "lift_vendor" => "Tweed",
            "lift_thc" => "",
            "lift_cbd" => "",
            "lift_des" => "Argyle is an indica-dominant strain with a balanced THC-to-CBD ratio. Its verdant green buds are quite dense and are accented by orange hairs. The terpene myrcene is responsible for Argyle's earthy aroma.",
            "lift_flavors" => "earthy, pine, sweet",
            "lift_effects" => ["Harsh" => 33.3333, "Weak" => 45, "Red Eyes" => 50, "Motivated" => 36.6667, "Sleepy" => 41.6667, "Giggly" => 45, "Anti-Anxiety" => 45, "Calming" => 46.6667],
            "urls" => [
                "https://www.leafly.com/products/details/tweed-argyle-flower?q=argyle&cat=product",
                "https://www.leafly.com/products/details/tweed-argyle-oil?q=argyle&cat=product",
                "https://www.leafly.com/products/details/tweed-argyle-softgels?q=argyle&cat=product"
            ]
        ],
        "bakerstreet" => [
            "lift_url" => "https://lift.co/strains/tweed-bakerstreet",
            "lift_vendor" => "Tweed",
            "lift_thc" => "",
            "lift_cbd" => "",
            "lift_des" => "The Bakerstreet cultivar is an indica-dominant THC strain. Its dense and deep green buds are highlighted with ochre-hued pistils and covered with trichomes. Terpinolene is the terpene which gives this strain its scent of juniper.",
            "lift_flavors" => "earthy, sweet, citrus",
            "lift_effects" => ["Talkative" => 40, "Lazy" => 43.3333, "Bad Taste" => 46.6667, "Motivated" => 15, "Calming" => 35, "Anxiety" => 36.6667, "Pain Relief" => 38.3333],
            "urls" => [
                "https://www.leafly.com/products/details/tweed-bakerstreet-flower?q=bakerstreet&cat=product",
                "https://www.leafly.com/products/details/tweed-bakerstreet-oil?q=bakerstreet&cat=product",
                "https://www.leafly.com/products/details/tweed-bakerstreet-softgel?q=bakerstreet&cat=product"
            ]
        ],
        "balance" => [
            "lift_url" => "https://lift.co/strains/solei-balance",
            "lift_vendor" => "Solei",
            "lift_thc" => "6.4",
            "lift_cbd" => "15.7",
            "lift_des" => "",
            "lift_flavors" => "earthy, citrus, musk",
            "lift_effects" => ["Bad Taste" => 75, "Dry Mouth" => 76.6667, "Headache" => 80, "Motivated" => 33.3333, "Social" => 36.6667, "Awake" => 53.3333, "Uplifted" => 53.3333, "Happy" => 53.3333],
            "urls" => ["https://www.leafly.com/products/details/solei-balance?q=balance&cat=product"]
        ],
        "balanced" => [
            "lift_url" => "https://lift.co/strains/plain-packaging-balanced",
            "lift_vendor" => "Plain Packaging",
            "lift_thc" => "13",
            "lift_cbd" => "13",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_effects" => ["Relaxed" => 58.3333, "Calming" => 66.6667]
        ],
        "balanced-milled" => [
            "lift_url" => "https://lift.co/strains/plain-packaging-plain-packaging-balanced-milled",
            "lift_vendor" => "Plain Packaging",
            "lift_thc" => "13",
            "lift_cbd" => "13",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_effects" => []
        ],
        "bali-kush" => [
            "lift_url" => "https://lift.co/strains/liiv-bali-kush",
            "lift_vendor" => "liiv",
            "lift_thc" => "22",
            "lift_cbd" => "1",
            "lift_des" => "This indica-dominant hybrid descends from the popular strains Black Afghani and Bubba Kush. Its olive tones fade into deep purple, framed by amber hairs and shimmering with a coating of trichomes. A woody, earthy aroma offers hints of sweet herbs and spices, and a lush hoppy flavour.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "43.3333", "relaxed" => "46.6667", "sleepy" => "50"],
            "urls" => [
                "https://www.leafly.com/products/details/liiv-bali-kush?q=bali-kush&cat=product",
                "https://www.leafly.com/products/details/liiv-bali-kush-pre-rolls?q=bali-kush&cat=product"
            ]
        ],
        "banana-split" => [
            "lift_url" => "https://lift.co/strains/aurora-recreational-banana-split",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "20",
            "lift_cbd" => "1",
            "lift_des" => "A rare, balanced hybrid strain with dense colas that house sweet, floral aromas. Aurora�s Banana Split is made up of large, dark green buds with vibrant orange pistil hairs and a thick coating of trichomes.",
            "lift_flavors" => "banana, sweet, fruit",
            "lift_badeffects" => ["dry mouth" => "56.6667"],
            "lift_goodeffects" => ["uplifted" => "45", "happy" => "48.3333", "relaxed" => "50", "calming" => "53.3333", "energetic" => "58.3333"],
            "urls" => [
                "https://www.leafly.com/products/details/dream-city-banana-split?q=banana-split&cat=product",
                "https://www.leafly.com/products/details/tall-tree-society-banana-split?q=banana-split&cat=product",
                "https://www.leafly.com/products/details/aurora-cannabis-inc-banana-split?q=banana-split&cat=product",
                "https://www.leafly.com/products/details/aroma-banana-split?q=banana-split&cat=product",
                "https://www.leafly.com/products/details/purehempshop-banana-split-e-liquid-150mg?q=banana-split&cat=product",
                "https://www.leafly.com/products/details/3c-farms-banana-split-og?q=banana-split&cat=product"
            ]
        ],
        "bc-delahaze" => [
            "lift_url" => "https://lift.co/strains/flowr-bc-delahaze",
            "lift_vendor" => "Flowr",
            "lift_thc" => "28",
            "lift_cbd" => "0",
            "lift_des" => "Delahaze is an award-winning cultivar known for its powerful, invigorating effects. Flowr�s BC Delahaze is expertly grown in our indoor facility to emphasize its potency and flavour, with citrus and mango notes. Carefully harvested, hand-trimmed and craft-cured, our BC Delahaze is sure to become one of your favourites.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
	        "lift_goodeffects" => ["energetic" => "66.6667", "awake" => "78.3333"],
            "urls" => ["https://www.leafly.com/products/details/flowr-bc-delahaze?q=bc-delahaze&cat=product"]
        ],
        "bc-pink-kush" => [
            "lift_url" => "https://lift.co/strains/flowr-bc-pink-kush",
            "lift_vendor" => "Flowr",
            "lift_thc" => "28",
            "lift_cbd" => "0",
            "lift_des" => "With origins in the Hindu Kush mountain range, Flowr�s Pink Kush is sweet-smelling product that is craft grown in BC and hand-trimmed to emphasize its pink hairs, bright green flower, and sugar-like trichomes.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => ["https://www.leafly.com/products/details/flowr-bc-pink-kush?q=bc-pink-kush&cat=product"]
        ],
        "bc-sensi-star" => [
            "lift_url" => "https://lift.co/strains/flowr-bc-sensi-star",
            "lift_vendor" => "Flowr",
            "lift_thc" => "17",
            "lift_cbd" => "0",
            "lift_des" => "Flowr�s BC Sensi Star is a legendary indica renowned for its dark Green and Purple colouration with sparkling crystal trichomes. This exceptional product is expertly grown in our indoor facility in Kelowna to emphasize its potency and flavour, which consists of earthy undertones with a hint of berry. Hand-trimmed and craft cured, Sensi Star is a must for everyone�s core product set.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => ["https://www.leafly.com/products/details/flowr-bc-sensi-star?q=bc-sensi-star&cat=product"]
        ],
        "blue-dream" => [
            "lift_url" => "https://lift.co/strains/aurora-recreational-blue-dream",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "22",
            "lift_cbd" => "0",
            "lift_des" => "A classic sativa-dominant hybrid strain, with dense light green buds. This high THC strain has a sweet berry, and pine aroma.",
            "lift_flavors" => "sweet, berry, earthy",
            "lift_badeffects" => ["cough" => "36.6667", "bad taste" => "66.6667", "dry eyes" => "66.6667"],
            "lift_goodeffects" => ["relaxed" => "25", "happy" => "28.3333", "uplifted" => "31.6667", "euphoric" => "46.6667", "social" => "50"],
            "urls" => [
                "https://www.leafly.com/hybrid/blue-dream?q=blue-dream&cat=strain",
                "https://www.leafly.com/products/details/item-9-labs-blue-dream?q=blue-dream&cat=product",
                "https://www.leafly.com/products/details/denver-terpenes-blue-dream?q=blue-dream&cat=product"
            ]
        ],
        "blueberry-kush" => [
            "lift_url" => "https://lift.co/strains/synrg-blueberry-kush",
            "lift_vendor" => "Synr.g",
            "lift_thc" => "23",
            "lift_cbd" => "1",
            "lift_des" => "Freshly baked blueberry pie, anyone? This hybrid�s fragrant lip-smacking berry flavour is complemented by a crisp citrus note. Dark blue and purple tones are topped by exquisite crystal bouquets of light green and golden hairs.",
            "lift_flavors" => "blueberry, berry, fruity",
            "lift_badeffects" => ["dry mouth" => "45"],
            "lift_goodeffects" => ["relaxed" => "33.3333", "sleepy" => "38.3333", "happy" => "58.3333", "euphoric" => "61.6667", "calming" => "61.6667"],
            "urls" => [
                "https://www.leafly.com/indica/blueberry-kush?q=blueberry-kush&cat=strain",//STRAIN
                "https://www.leafly.com/products/details/thclear-disposable-pens-blueberry-kush-1-gram?q=blueberry-kush&cat=product",
                "https://www.leafly.com/products/details/moani-naturals-blueberry-kush?q=blueberry-kush&cat=product",
                "https://www.leafly.com/products/details/denver-terpenes-blueberry-kush?q=blueberry-kush&cat=product",
                "https://www.leafly.com/products/details/synrg-blueberry-kush?q=blueberry-kush&cat=product",
                "https://www.leafly.com/products/details/pioneer-nuggets-blueberry-kush?q=blueberry-kush&cat=product"
            ]
        ],
        "blueberry-seagal" => [
            "lift_url" => "https://lift.co/strains/weedmd-blueberry-seagal",
            "lift_vendor" => "WeedMD",
            "lift_thc" => "18",
            "lift_cbd" => "0",
            "lift_des" => "Blueberry Seagal is a WeedMD Indica dominant proprietary strain that has been hand selected by our phenotype hunters. This strain has crisp concentrated hints of blueberries while harbouring sweet floral undertones. The inflorescences are light green with light orange hues throughout.",
            "lift_flavors" => "blueberry, berry, sweet",
            "lift_badeffects" => ["dry mouth" => "93.3333"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["insomnia" => "33.3333", "stress" => "36.6667", "depression" => "38.3333", "anxiety" => "46.6667"],
            "urls" => ["https://www.leafly.com/products/details/weedmd-blueberry-seagull?q=blueberry-seagal&cat=product"]
        ],
        "cabaret" => [
            "lift_url" => "https://lift.co/strains/altavie-cabaret",
            "lift_vendor" => "Altavie",
            "lift_thc" => "20.3",
            "lift_cbd" => "0",
            "lift_des" => "Cabaret is a sativa-dominant strain that offers a sweet and floral aroma with hints of grapefruit. It is made up of loose and sticky buds that are cone shaped, similar to arrowheads. In terms of colour, Cabaret is light green and accented by thick, bright orange hairs.",
            "lift_flavors" => "herbal, earthy, floral",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["euphoric" => "26.6667", "energetic" => "28.3333", "relaxed" => "45", "focused" => "56.6667"],
            "urls" => ["https://www.leafly.com/products/details/altavie-cabaret?q=cabaret&cat=product"]
        ],
        "campfire" => [
            "lift_url" => "https://lift.co/strains/altavie-campfire",
            "lift_vendor" => "Altavie",
            "lift_thc" => "4.6",
            "lift_cbd" => "7.3",
            "lift_des" => "Campfire is a mild THC, high-CBD strain with rich, floral notes. Physically, expect somewhat dense, light green buds with hues of yellow and lots of orange hairs.",
            "lift_flavors" => "earthy, herbal, floral",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "46.6667", "calming" => "51.6667", "sleepy" => "53.3333", "uplifted" => "53.3333", "euphoric" => "70"],
            "urls" => ["https://www.leafly.com/products/details/altavie-campfire?q=campfire&cat=product"]
        ],
        "casablanca" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-casablanca",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "citrus",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "41.6667", "calming" => "45", "happy" => "46.6667", "sleepy" => "56.6667", "appetite enhancing" => "60"],
            "urls" => [
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-casablanca?q=casablanca&cat=product",
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-casa-blanca-pre-roll?q=casablanca&cat=product",
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-casablanca-reserve?q=casablanca&cat=product"
            ]
        ],
        "cbd-shark-shock-redecan" => [
            "lift_url" => "https://lift.co/strains/redecan-cbd-shark-shock",
            "lift_vendor" => "Redecan",
            "lift_thc" => "7",
            "lift_cbd" => "12",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => ["dry mouth" => "86.6667"],
            "lift_goodeffects" => ["calming" => "53.3333"],
            "urls" => [
                "https://www.leafly.com/indica/shark-shock?q=shark-shock&cat=strain",
                "https://www.leafly.com/products/details/alter-farms-shark-shock?q=shark-shock&cat=product",
                "https://www.leafly.com/products/details/redecan-shark-shock?q=shark-shock&cat=product",
                "https://www.leafly.com/products/details/sweet-as-cannabis-co-shark-shock-cbd?q=shark-shock&cat=product",
                "https://www.leafly.com/products/details/rythm-heal-hits-cartridge-1000mg-shark-shock-11?q=shark-shock&cat=product",
                "https://www.leafly.com/products/details/redecan-shark-shock-drops?q=shark-shock&cat=product"
            ]
        ],
        "chocolate-fondue" => [
            "lift_url" => "https://lift.co/strains/dna-genetics-chocolate-fondue",
            "lift_vendor" => "DNA Genetics",
            "lift_thc" => "0",
            "lift_cbd" => "0",
            "lift_des" => "This sativa-dominant THC strain is a well-balanced cross of Exodus UK Cheese and Chocolope. Chocolate Fondue has a complex aroma that is funky, robust and sweet like chocolate. Bred by DNA Genetics.",
            "lift_flavors" => "sweet, cheese, earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["uplifted" => "33.3333", "focused" => "36.6667", "energetic" => "43.3333", "social" => "45", "calming" => "48.3333"],
            "urls" => [
                "https://www.leafly.com/products/details/dna-chocolate-fondue-bud?q=chocolate-fondue&cat=product",
                "https://www.leafly.com/sativa/chocolate-fondue?q=chocolate-fondue&cat=strain"
            ]
        ],
        "city-lights" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-city-lights",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "48.3333", "calming" => "51.6667", "happy" => "58.3333", "euphoric" => "78.3333"],
            "urls" => [
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-city-lights?q=city-lights&cat=product",
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-city-lights-pre-roll?q=city-lights&cat=product"
            ]
        ],
        "cold-creek-kush" => [
            "lift_url" => "https://lift.co/strains/beleave-cold-creek-kush",
            "lift_vendor" => "Beleave",
            "lift_thc" => "19",
            "lift_cbd" => "0.1",
            "lift_des" => "Cold Creek Kush is an Indica-dominant hybrid that crosses the powerful MK Ultra and Chemdawg 91. Piney and sour, users love its fresh taste and balanced effects.",
            "lift_flavors" => "kush, smooth, earthy",
            "lift_badeffects" => ["dry eyes" => "75", "dry mouth" => "83.3333", "red eyes" => "100"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["inflammation" => "11.6667", "anxiety" => "28.3333", "back pain" => "30", "insomnia" => "38.3333"],
            "urls" => [
                "https://www.leafly.com/products/details/seven-oaks-cold-creek-kush?q=cold-creek-kush&cat=product",
                "https://www.leafly.com/products/details/redecan-cold-creek-kush?q=cold-creek-kush&cat=product",
                "https://www.leafly.com/products/details/dutchie-products-dutchie-cold-creek-kush?q=cold-creek-kush&cat=product",
                "https://www.leafly.com/products/details/weedmd-cold-creek-kusk?q=cold-creek-kush&cat=product"
            ]
        ],
        "critical-super-silver-haze" => [
            "lift_url" => "https://lift.co/strains/canna-farms-critical-super-silver-haze",
            "lift_vendor" => "Canna Farms",
            "lift_thc" => "16.8",
            "lift_cbd" => "0.1",
            "lift_des" => "A colourful plant, Critical Super Silver Haze is known for it's slightly citrusy aromas with incense and mentholated wood notes with hints of haze and even pungent varnish. Flowers are dense, coated with trichomes, and contain hints of purple colour throughout.",
            "lift_flavors" => "citrus, earthy, citrusy",
            "lift_badeffects" => ["lazy" => "50", "hungry" => "50", "weak" => "53.3333"],
            "lift_goodeffects" => ["tasteful" => "23.3333", "happy" => "31.6667", "uplifted" => "35", "energetic" => "35", "alert" => "36.6667"],
            "urls" => ["https://www.leafly.com/products/details/canna-farms-critical-super-silver-haze?q=critical-super-silver-haze&cat=product"]
        ],
        "delahaze" => [
            "lift_url" => "https://lift.co/strains/san-rafael-71-delahaze",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => 25,
            "lift_cbd" => 0,
            "lift_des" => "Delahaze is a sativa strain posessing mango notes and sticky, cone-like buds. It is light green in colour with thin orange hairs running throughout.",
            "lift_flavors" => "citrus, lemon, sweet",
            "lift_effects" => ["Dry Mouth" => 73.3333, "Happy" => 31.6667, "Euphoric" => 36.6667, "Uplifted" => 50, "Energetic" => 50, "Awake" => 51.6667],
            "urls" => [
                "https://www.leafly.com/products/details/san-rafael-71-delahaze?q=delahaze&cat=product",
                "https://www.leafly.com/products/details/flowr-bc-delahaze?q=delahaze&cat=product",
                "https://www.leafly.com/sativa/delahaze?q=delahaze&cat=strain"
            ]
        ],
        "easy-cheesy" => [
            "lift_url" => "https://lift.co/strains/liiv-easy-cheesy",
            "lift_vendor" => "liiv",
            "lift_thc" => "20",
            "lift_cbd" => "1",
            "lift_des" => "This sativa-dominant descendent of Original Cheese has sharp, rich, sour notes, giving it its cheesy name. The dark green buds, accented by bright copper hairs, produce an extra old cheddar aroma, and a ?oral, pine aftertaste.",
            "lift_flavors" => "cheese",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => [
                "https://www.leafly.com/products/details/liiv-easy-cheesy?q=easy-cheesy&cat=product",
                "https://www.leafly.com/products/details/liiv-easy-cheesy-pre-rolls?q=easy-cheesy&cat=product"
            ]
        ],
        "fantasy-island" => [
            "lift_url" => "https://lift.co/strains/synrg-fantasy-island",
            "lift_vendor" => "Synr.g",
            "lift_thc" => "15",
            "lift_cbd" => "1",
            "lift_des" => "This indica-dominant hybrid features bright amber hairs exploding through a thick green canopy. The medium sized buds are compact with a wool-like structure; taste buds tingle from the luxurious tang of rich berry, sweet pine, and hints of pumpkin spice.",
            "lift_flavors" => "fruity, berry, citrus",
            "lift_badeffects" => ["dry mouth" => "76.6667"],
            "lift_goodeffects" => ["relaxed" => "35", "happy" => "40", "calming" => "45", "euphoric" => "51.6667", "sleepy" => "53.3333"],
            "urls" => [
                "https://www.leafly.com/products/details/synrg-fantasy-island?q=fantasy-island&cat=product",
                "https://www.leafly.com/products/details/synrg-fantasy-island-pre-rolls?q=fantasy-island&cat=product"
            ]
        ],
        "fleur-de-lune-intimate" => [
            "lift_url" => "https://lift.co/oils/hydropothecary-fleur-de-lune-intimate-spray",
            "lift_vendor" => "Hydropothecary",
            "lift_thc" => "10 mg/ml",//WARNING
            "lift_cbd" => "1 mg/ml",//WARNING
            "lift_des" => "Easy to use and convenient, Fleur de Lune is a THC intimate oil containing up to 600mg of THC. One 60ml bottle offers up to 460 sprays. Equivalency factor for purchasing calculations 60 ml bottle = 6 g dried cannabis(10 ml cannabis oil = 1 g dried cannabis)",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => ["https://www.leafly.com/products/details/hexo-fleur-de-lune-intimate-spray?q=fleur-de-lune-intimate&cat=product"]
        ],
        "galiano" => [
            "lift_url" => "https://lift.co/strains/broken-coast-cannabis-galiano",
            "lift_vendor" => "Broken Coast Cannabis",
            "lift_thc" => "19.6",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy, herbal",
            "lift_badeffects" => ["hungry" => "70", "dry mouth" => "95"],
            "lift_goodeffects" => ["uplifted" => "21.6667", "happy" => "41.6667", "appetite enhancing" => "45", "awake" => "48.3333", "creative" => "48.3333"],
            "urls" => ["https://www.leafly.com/products/details/broken-coast-galiano?q=galiano&cat=product"]
        ],
        "gather" => [
            "lift_url" => "https://lift.co/strains/solei-gather-strain",
            "lift_vendor" => "Solei",
            "lift_thc" => "24.7",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["awake" => "46.6667", "happy" => "50", "energetic" => "58.3333"],
            "urls" => [
                "https://www.leafly.com/products/details/solei-gather?q=gather&cat=product",
                "https://www.leafly.com/products/details/solei-gather-oral-spray?q=gather&cat=product"
            ]
        ],
        "gems" => [
            "lift_url" => "https://lift.co/strains/up-gems",
            "lift_vendor" => "UP",
            "lift_thc" => "20",
            "lift_cbd" => "0.3",
            "lift_des" => "Gems is our high trichome hybrid sativa-dominant premium flower grown in our Great Emerald Hall in the Niagara region.  Gems is hand-finished, hand-sorted and managed throughout the entire growth cycle with the state-of-the-art Dutch Tray System. This hybrid produces impressive buds that are blanketed with white, crystal-capped trichomes along with vibrant orange hairs. This flower exudes a pleasant fruity aroma.",
            "lift_flavors" => "herbal",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "ghost-train-haze" => [
            [
                "lift_url" => "https://lift.co/strains/weedmd-ghost-train-haze",
                "lift_vendor" => "WeedMD",
                "lift_thc" => "26",
                "lift_cbd" => "0.1",
                "lift_des" => "Ghost Train Haze is a sativa dominant strain with typical sativa stretching. The dense inflorescences (buds) are a lighter green with orange/golden complimentary tones. The lineage of Ghost Train Haze is Ghost OG x Neviles Wreck. Ghost OG is an indica dominant strain and Neviles Wreck is a sativa dominant strain. Ghost Train Haze has notes of floral, citrus and hints of spice.",
                "lift_flavors" => "earthy, citrus, pungent",
                "lift_badeffects" => ["coughing" => "53.3333", "dry eyes" => "60", "dry mouth" => "68.3333"],
                "lift_goodeffects" => ["social" => "25", "happy" => "36.6667", "motivated" => "40", "euphoric" => "40", "tasteful" => "41.6667"],
                "urls" => [
                    "https://www.leafly.com/sativa/ghost-train-haze?q=ghost-train-haze&cat=strain",
                    "https://www.leafly.com/products/details/verano-ghost-train-haze?q=ghost-train-haze&cat=product",
                    "https://www.leafly.com/products/details/ataraxia-goldleaf-ghost-train-haze?q=ghost-train-haze&cat=product",
                    "https://www.leafly.com/products/details/hightide-ghost-train-haze?q=ghost-train-haze&cat=product",
                    "https://www.leafly.com/products/details/aurora-cannabis-inc-ghost-train-haze?q=ghost-train-haze&cat=product",
                    "https://www.leafly.com/products/details/weedmd-ghost-train-haze?q=ghost-train-haze&cat=product"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/aurora-recreational-ghost-train-haze",
                "lift_vendor" => "Aurora - Recreational",
                "lift_thc" => "22",
                "lift_cbd" => "1",
                "lift_des" => "A high�THC�sativa�strain with a sweet and piney aroma with�hints�of�citrus,�lemon,�and�spice. Aurora's�Ghost�Train�Haze�is made up of�large,�dark green buds�beautifully�entwined�with�bright orange�pistil�hairs.",
                "lift_flavors" => "earthy",
                "lift_badeffects" => ["dry mouth" => "50"],
                "lift_goodeffects" => ["uplifted" => "36.6667", "awake" => "66.6667", "happy" => "66.6667"]
            ],[
                "lift_url" => "https://lift.co/strains/redecan-pharm-ghost-train-haze",
                "lift_vendor" => "RedeCan Pharm",
                "lift_thc" => "24.8",
                "lift_cbd" => "10.7",
                "lift_des" => "Sativa Dominant80% Sativa/ 20% IndicaCross between: Ghost OG and Neville�s Wreck",
                "lift_flavors" => "woody, citrus",
                "lift_badeffects" => ["dry eyes" => "60"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["anxiety" => "30", "back pain" => "36.6667"]
            ]
        ],
        "god-bud" => [
            "lift_url" => "https://lift.co/strains/redecan-god-bud",
            "lift_vendor" => "RedeCan Pharm",
            "lift_thc" => "19",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "citrus, berry",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "33.3333", "euphoric" => "41.6667", "sleepy" => "48.3333", "calming" => "58.3333"],
            "urls" => [
                "https://www.leafly.com/indica/god-bud?q=god-bud&cat=strain",
                "https://www.leafly.com/products/details/campos-de-kush-god-bud?q=god-bud&cat=product",
                "https://www.leafly.com/products/details/roll-model-god-bud-single-1g?q=god-bud&cat=product"
            ]
        ],
        "great-white-shark" => [
            "lift_url" => "https://lift.co/strains/san-rafael-71-great-white-shark",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => "7.3",
            "lift_cbd" => "13.9",
            "lift_des" => "Great White Shark is a carefully cultivated 2:1 sativa strain that offers the benefits of both CBD and THC. Enhanced by a unique and earthy aroma, this strain is very sticky and resinous to the touch, with light green leaves and dark, thick orange hairs.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "33.3333", "focused" => "36.6667", "relaxed" => "43.3333"],
            "urls" => [
                "https://www.leafly.com/sativa/white-shark?q=great-white-shark&cat=strain",
                "https://www.leafly.com/products/details/san-rafael-71-great-white-shark?q=great-white-shark&cat=product",
                "https://www.leafly.com/products/details/royal-high-great-white-shark?q=great-white-shark&cat=product",
                "https://www.leafly.com/products/details/mainland-cannabis-great-white-shark?q=great-white-shark&cat=product",
                "https://www.leafly.com/products/details/apollo-grown-great-white-shark-crumble?q=great-white-shark&cat=product"
            ]
        ],
        "gsc" => [
            "lift_url" => "https://lift.co/strains/canna-farms-gsc",
            "lift_vendor" => "Canna Farms",
            "lift_thc" => "22",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => ["dry mouth" => "78.3333"],
            "lift_goodeffects" => ["happy" => "16.6667", "relaxed" => "33.3333", "calming" => "36.6667"],
            "urls" => [
                "https://www.leafly.com/hybrid/gsc?q=gsc&cat=strain",
                "https://www.leafly.com/products/details/experience-cbd-thick-liq-gsc-gsc-fka-girl-scout-cookies-600mg?q=gsc&cat=product",
                "https://www.leafly.com/products/details/alpine-vapor-alpine-vapor-gsc-premium-cannabis-oil-cartridge-1g?q=gsc&cat=product"
            ]
        ],
        "harmonic" => [
            "lift_url" => "https://lift.co/strains/altavie-harmonic",
            "lift_vendor" => "Altavie",
            "lift_thc" => "10.6",
            "lift_cbd" => "10.1",
            "lift_des" => "Harmonic is a balanced strain that maximizes on both cannabinoids by having equal parts CBD and THC. With fairly loose and airy flowers, the buds of this unique strain range from long and thin to spherical in shape. This product is made up of dark green buds interlaced with dark orange hairs, and is available as dried flowers and soft-gels.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "56.6667", "relaxed" => "66.6667"],
            "urls" => ["https://www.leafly.com/products/details/altavie-harmonic?q=harmonic&cat=product"]
        ],
        "highlands" => [
            "lift_url" => "https://lift.co/strains/tweed-highlands",
            "lift_vendor" => "Tweed",
            "lift_thc" => "2.5 mg/ml",
            "lift_cbd" => "0.7 mg/ml",
            "lift_des" => "This indica-dominant THC strain has Afghan ancestry and dense, trichome-rich flowers. The terpene profile tends to lead with myrcene and balances out with notes of clove and pine from caryophyllene and pinene.",
            "lift_flavors" => "earthy, dank, chemical",
            "lift_badeffects" => ["harsh" => "43.3333", "cough" => "73.3333", "dry mouth" => "78.3333"],
            "lift_goodeffects" => ["euphoric" => "43.3333", "relaxed" => "48.3333", "calming" => "50"]
        ],
        "houndstooth" => [
            "lift_url" => "https://lift.co/strains/tweed-houndstooth",
            "lift_vendor" => "Tweed",
            "lift_thc" => "9",
            "lift_cbd" => "12",
            "lift_des" => "Houndstooth is a sativa-dominant, THC strain. Its buds have a nice purple hue and possess a complex aroma from the terpenes myrcene, which tends to have a sweet and earthy scent, as well as pinene, which is also found in pine needles.",
            "lift_flavors" => "sweet, citrus, earthy",
            "lift_badeffects" => ["harsh" => "48.3333", "bad taste" => "50"],
            "lift_goodeffects" => ["motivated" => "36.6667", "awake" => "36.6667", "focused" => "38.3333", "calming" => "40"],
            "urls" => [
                "https://www.leafly.com/products/details/tweed-houndstooth-flower?q=houndstooth&cat=product",
                "https://www.leafly.com/products/details/tweed-houndstooth-oil?q=houndstooth&cat=product",
                "https://www.leafly.com/products/details/tweed-houndstooth-oil?q=houndstooth&cat=product",
                "https://www.leafly.com/products/details/tweed-houndstooth-softgels?q=houndstooth&cat=product"
            ]
        ],
        "kinky-kush" => [
            "lift_url" => "https://lift.co/strains/liiv-kinky-kush",
            "lift_vendor" => "liiv",
            "lift_thc" => "27",
            "lift_cbd" => "1",
            "lift_des" => "Descending from award-winning Californian genetics, this indica showcases a dusting of trichomes that crown the dense forest of green. A smoky, woody, pine aroma highlighted by hints of lilac greets the nostrils.THC: 27%CBD: ?1% Dried Flower: 1 g, 3.5 g, 7 g Pre-Rolled Joints: 1x1 g, 2x0.5 g, 5x0.5 g",
            "lift_flavors" => "earthy, kush, pine",
            "lift_badeffects" => ["sleepy" => "71.6667", "dry mouth" => "75", "cough" => "78.3333"],
            "lift_goodeffects" => ["sleepy" => "38.3333", "relaxed" => "38.3333", "appetite enhancing" => "43.3333", "calming" => "48.3333", "happy" => "50"],
            "urls" => [
                "https://www.leafly.com/products/details/liiv-kinky-kush?q=kinky-kush&cat=product",
                "https://www.leafly.com/products/details/liiv-kinky-kush-pre-rolls?q=kinky-kush&cat=product"
            ]
        ],
        "la-strada" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-la-strada",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["awake" => "58.3333"],
            "urls" => ["https://www.leafly.com/products/details/edison-cannabis-co-edison-la-strada?q=la-strada&cat=product"]
        ],
        "lemon-skunk" => [
            "lift_url" => "https://lift.co/strains/dna-genetics-lemon-skunk",
            "lift_vendor" => "DNA Genetics",
            "lift_thc" => "25 mg/ml",
            "lift_cbd" => "0.7 mg/ml",
            "lift_des" => "12-22% THC | <0.07% CBD\nLemon Skunk is a cross between two Skunk strains, the chosen phenotype selected for its lemon characteristics. Lemon Skunk brings together the scent of lemons, black pepper and hints of citrus. Its buds are light green with thick orange hairs and a high calyx to leaf ratio. Lemon Skunk has a mid-range THC content. Bred by DNA Genetics.�",
            "lift_flavors" => "lemon, citrus, earthy",
            "lift_badeffects" => ["weak" => "45", "dry eyes" => "58.3333", "dry mouth" => "61.6667"],
            "lift_goodeffects" => ["tasteful" => "25", "uplifted" => "36.6667", "creative" => "40", "euphoric" => "40", "focused" => "41.6667"],
            "urls" => [
                "https://www.leafly.com/hybrid/lemon-skunk?q=lemon-skunk&cat=strain",
                "https://www.leafly.com/products/details/bellevue-farms-super-lemon-haze?q=lemon-skunk&cat=product",
                "https://www.leafly.com/products/details/emerald-family-farms-lemon-skunk?q=lemon-skunk&cat=product",
                "https://www.leafly.com/products/details/in-the-flow-lemon-skunk?q=lemon-skunk&cat=product",
                "https://www.leafly.com/products/details/vapenterps-500mg-lemon-skunk-cbd-vape-cartridge?q=lemon-skunk&cat=product"
            ]
        ],
        "lola-montes" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-lola-montes",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["sleepy" => "25", "relaxed" => "36.6667", "calming" => "46.6667"],
            "urls" => ["https://www.leafly.com/products/details/edison-cannabis-co-lola-montes?q=lola-montes&cat=product"]
        ],
        "lola-montes-reserve" => [
            "lift_url" => "https://lift.co/strains/edison-reserve-lola-montes-reserve",
            "lift_vendor" => "Edison Reserve",
            "lift_thc" => "22",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => ["https://www.leafly.com/products/details/edison-cannabis-co-edison-lola-montes-reserve?q=lola-montes&cat=product"]
        ],
        "mango-haze" => [
            [
                "lift_url" => "https://lift.co/strains/weedmd-mango-haze",
                "lift_vendor" => "WeedMD",
                "lift_thc" => "9",
                "lift_cbd" => "14.7",
                "lift_des" => "Mango Haze is a mostly Sativa strain, who crossed Northern Lights #5, Skunk, and Haze to create this uplifting, fruity variety. Mango Haze exhibits a distinctive mango aroma coupled with spicy, sour undertones. The inflorescences (buds) are dark green, resinous and dense with bright orange pistils.",
                "lift_flavors" => "mango, fruity, citrus",
                "lift_badeffects" => ["dry eyes" => "63.3333", "dry mouth" => "68.3333"]
                ,"lift_goodeffects" => [],
                "lift_symptoms" => ["stress" => "18.3333", "fatigue" => "28.3333", "mood" => "31.6667", "pain" => "36.6667", "headaches" => "38.3333"],
                "urls" => [
                    "https://www.leafly.com/sativa/mango-haze?q=mango-haze&cat=strain",
                    "https://www.leafly.com/products/details/aroma-mango-haze?q=mango-haze&cat=product",
                    "https://www.leafly.com/products/details/kiwi-cannabis-mango-haze?q=mango-haze&cat=product",
                    "https://www.leafly.com/products/details/roll-model-mango-haze-3-pack-15g?q=mango-haze&cat=product",
                    "https://www.leafly.com/products/details/flavrx-mango-haze-all-in-one-disposable?q=mango-haze&cat=product",
                    "https://www.leafly.com/products/details/dream-city-cbd-mango-haze?q=mango-haze&cat=product"
                ]
            ], [
                "lift_url" => "https://lift.co/strains/kiwi-cannabis-mango-haze",
                "lift_vendor" => "Kiwi Cannabis",
                "lift_thc" => "10",
                "lift_cbd" => "5",
                "lift_des" => "",
                "lift_flavors" => "citrus, mango, earthy",
                "lift_badeffects" => [],
                "lift_goodeffects" => ["calming" => "50", "focused" => "53.3333", "relaxed" => "56.6667", "euphoric" => "60", "awake" => "63.3333"]
            ]
        ],
        "moon" => [
            "lift_url" => "https://lift.co/strains/up-moon",
            "lift_thc" => "8",
            "lift_cbd" => "12",
            "lift_des" => "Moon is our mild, fragrant 1:2 CBD hybrid flower that is grown in our Great Emerald Hall in the Niagara region where it is hand-finished, hand-sorted and managed throughout the entire growth cycle with the state-of-the-art Dutch Tray System resulting in a premium flower bud.   It has an herbal, musky taste and a tropical, earthy smell. This resin-coated bud features flaming orange hairs and an abundance of white crystal trichomes.",
            "lift_flavors" => "piney",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "40", "calming" => "45", "focused" => "61.6667"],
            "lift_vendor" => "UP"
        ] ,
        "napali-cbd" => [
            "lift_url" => "https://lift.co/strains/haven-st-napali-cbd",
            "lift_vendor" => "Haven St.",
            "lift_thc" => "6.5",
            "lift_cbd" => "8.5",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "25", "calming" => "41.6667"],
            "urls" => ["https://www.leafly.com/products/details/haven-st-napali-cbd?q=napali-cbd&cat=product"]
        ],
        "north-star-cbd" => [
            "lift_url" => "https://lift.co/strains/altavie-north-star-cbd",
            "lift_vendor" => "Altavie",
            "lift_thc" => "0.7",
            "lift_cbd" => "16",
            "lift_des" => "A rare strain with bold floral scents, North Star is ideal for those seeking the benefits of CBD. It's made up of sticky, dense, medium-sized buds that are dark green in colour with hues of light purple. North Star comes in dried flower and soft-gel form to meet the needs of all our clients.",
            "lift_flavors" => "earthy, flowery",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "28.3333", "happy" => "41.6667", "focused" => "43.3333", "calming" => "43.3333", "uplifted" => "61.6667"],
            "urls" => ["https://www.leafly.com/products/details/altavie-north-star-cbd?q=north-star-cbd&cat=product"]
        ],
        "northern-lights-moc" => [
            "lift_url" => "https://lift.co/strains/united-greeneries-northern-lights-moc",
            "lift_vendor" => "United Greeneries",
            "lift_thc" => "12.4",
            "lift_cbd" => "0",
            "lift_des" => "Northern Lights MOC is a classic strain that was concocted near the end of the 80s. This is a quality indica composed of 100% Northern Lights genetics.�Proudly cultivated on Vancouver Island in British Columbia. Dominant Terpene Profile: Myrcene (terpenic, rose, herbal) Alpha Pinene (fresh, sweet, earthy)",
            "lift_flavors" => "smooth, lemon, sweet",
            "lift_badeffects" => ["red eyes" => "78.3333"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["stress" => "6.66667", "anxiety" => "13.3333", "pain" => "30"],
            "urls" => [
                "https://www.leafly.com/products/details/ministry-of-cannabis-northern-lights-moc?q=northern-lights-moc&cat=product",
                "https://www.leafly.com/products/details/crafted-extracts-northern-lights?q=northern-lights-moc&cat=product"
            ]
        ],
        "palm-tree" => [
            "lift_url" => "https://lift.co/strains/lbs-palm-trees-cbd-indica",
            "lift_vendor" => "LBS",
            "lift_thc" => "17",
            "lift_cbd" => "12",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => [
                "https://www.leafly.com/indica/palm-tree-cbd?q=palm-tree&cat=strain",
                "https://www.leafly.com/products/details/lbs-palm-tree-cbd?q=palm-tree&cat=product"
            ]
        ],
        "pink-kush" => [
            "lift_url" => "https://lift.co/strains/tilray-pink-kush",
            "lift_vendor" => "Tilray",
            "lift_thc" => "25.1",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy, sweet, flowery",
            "lift_badeffects" => ["red eyes" => "53.3333", "coughing" => "53.3333", "dry eyes" => "60"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["appetite" => "35", "insomnia" => "35", "mood" => "38.3333", "muscle pain" => "40", "nausea" => "40"],
            "urls" => [
                "https://www.leafly.com/hybrid/pink-kush?q=pink-kush&cat=strain",
                "https://www.leafly.com/products/details/aeriz-pink-kush?q=pink-kush&cat=product",
                "https://www.leafly.com/products/details/tilray-pink-kush?q=pink-kush&cat=product",
                "https://www.leafly.com/products/details/canna-farms-pink-kush?q=pink-kush&cat=product",
                "https://www.leafly.com/products/details/san-rafael-71-pink-kush?q=pink-kush&cat=product"
            ]
        ],
        "purple-chitral" => [
            "lift_url" => "https://lift.co/strains/san-rafael-71-purple-chitral",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => "21",
            "lift_cbd" => "0",
            "lift_des" => "This mid-potency indica strain features a unique cheese aroma with hints of berry. Its buds are dark purple and dense, with little to no orange hairs. This strain is made up of large calyxes that appear like concord grapes, creating buds that are dense and cone-shaped.",
            "lift_flavors" => "berry, floral, earthy",
            "lift_badeffects" => ["hungry" => "78.3333"],
            "lift_goodeffects" => ["relaxed" => "35", "giggly" => "45", "happy" => "53.3333", "calming" => "55", "sleepy" => "56.6667"],
            "urls" => [
                "https://www.leafly.com/indica/pakistani-chitral-kush?q=purple-chitral&cat=strain",
                "https://www.leafly.com/products/details/san-rafael-71-purple-chitral?q=purple-chitral&cat=product",
                "https://www.leafly.com/products/details/the-woodstock-cannabis-company-woodstock-purple-chitral?q=purple-chitral&cat=product"
            ]
        ],
        "quadra" => [
            "lift_url" => "https://lift.co/strains/broken-coast-cannabis-quadra-headstash-strain",
            "lift_vendor" => "Broken Coast Cannabis",
            "lift_thc" => "17",
            "lift_cbd" => "0.1",
            "lift_des" => "A Sativa/indica hybrid with BC Kush and Burmese genetic origins. This nicely balanced strain is often described as flavourful and well-rounded, and produces effects in both the head and body. A versatile all around strain for many patients.",
            "lift_flavors" => "lime, citrus, earthy",
            "lift_badeffects" => ["anxiety" => "46.6667", "dry eyes" => "50", "dry mouth" => "70"],
            "lift_goodeffects" => ["happy" => "33.3333", "calming" => "33.3333", "euphoric" => "41.6667", "creative" => "43.3333", "sleepy" => "45"]
        ],
        "red" => [
            "lift_url" => "https://lift.co/strains/fireside-red",
            "lift_vendor" => "Fireside",
            "lift_thc" => "18",
            "lift_cbd" => "0.1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "reflect" => [
            "lift_url" => "https://lift.co/strains/cove-reflect",
            "lift_vendor" => "COVE",
            "lift_thc" => "25",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => ["dry mouth" => "66.6667"],
            "lift_goodeffects" => ["motivated" => "41.6667", "calming" => "66.6667"],
            "urls" => ["https://www.leafly.com/products/details/cove-reflect?q=reflect&cat=product"]
        ],
        "rest" => [
            "lift_url" => "https://lift.co/strains/cove-rest",
            "lift_vendor" => "COVE",
            "lift_thc" => "24",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["euphoric" => "46.6667", "relaxed" => "48.3333", "sleepy" => "48.3333", "calming" => "53.3333"]
        ],
        "rio-bravo" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-rio-bravo",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "earthy, earth",
            "lift_badeffects" => ["dry mouth" => "83.3333"],
            "lift_goodeffects" => ["creative" => "50", "energetic" => "51.6667", "awake" => "51.6667", "happy" => "53.3333", "relaxed" => "56.6667"],
            "urls" => [
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-rio-bravo?q=rio-bravo&cat=product",
                "https://www.leafly.com/products/details/edison-cannabis-co-edison-rio-bravo-pre-roll?q=rio-bravo&cat=product"
            ]
        ],
        "rise" => [
            "lift_url" => "https://lift.co/strains/cove-rise",
            "lift_vendor" => "COVE",
            "lift_thc" => "23",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "citrusy, earthy, floral",
            "lift_badeffects" => ["dry mouth" => "88.3333"],
            "lift_goodeffects" => ["awake" => "23.3333", "happy" => "28.3333", "euphoric" => "33.3333", "creative" => "56.6667"]
        ],
        "san-fernando-valley" => [
            "lift_url" => "https://lift.co/strains/weedmd-san-fernando-valley",
            "lift_vendor" => "WeedMD",
            "lift_thc" => "16.9",
            "lift_cbd" => "0",
            "lift_des" => "San Fernando Valley is a sativa dominant hybrid that is related to OG Kush. This strain is the precursor to the indica dominant SFV OG. The aroma is sweet and mingles with hints of mellow citrus and berries, an interesting terpene profile. The inflorescences of WeedMD�s San Fernando Valley are dense with a spectrum of purple hues.",
            "lift_flavors" => "berry, citrusy, earthy",
            "lift_badeffects" => ["dry mouth" => "58.3333", "hungry" => "61.6667"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["depression" => "16.6667", "stress" => "28.3333", "mood" => "33.3333", "pain" => "38.3333", "lack of appetite" => "40"],
            "urls" => [
                "https://www.leafly.com/products/details/marks-organix-san-fernando-valley?q=san-fernando-valley&cat=product",
                "https://www.leafly.com/products/details/topleaf-canada-san-fernando-valley-sativa-organic-bc-weed-co?q=san-fernando-valley&cat=product",
                "https://www.leafly.com/products/details/marks-organix-san-fernando-valley-600mg-distillate-cartridge?q=san-fernando-valley&cat=product"
            ]
        ],
        "saturday-night" => [
            "lift_url" => "https://lift.co/strains/saturday-saturday-night-pre-roll",
            "lift_vendor" => "Saturday",
            "lift_thc" => "14",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => [
                "https://www.leafly.com/products/details/saturday-saturday-night?q=saturday-night&cat=product",
                "https://www.leafly.com/products/details/saturday-saturday-night-oil?q=saturday-night&cat=product",
                "https://www.leafly.com/products/details/saturday-saturday-night-pre-roll?q=saturday-night&cat=product"
            ]
        ],
        "serious-kush" => [
            "lift_url" => "https://lift.co/strains/royal-high-serious-kush",
            "lift_vendor" => "Royal High",
            "lift_thc" => "18.3",
            "lift_cbd" => "0.1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => ["https://www.leafly.com/products/details/royal-high-serious-kush?q=serious-kush&cat=product"]
        ],
        "shishkaberry" => [
            [
                "lift_url" => "https://lift.co/strains/redecan-shishkaberry",
                "lift_vendor" => "Redecan",
                "lift_thc" => "16",
                "lift_cbd" => "1",
                "lift_des" => "",
                "lift_flavors" => "berry",
                "lift_badeffects" => [],
                "lift_goodeffects" => ["calming" => "53.3333", "sleepy" => "66.6667", "relaxed" => "70"],
                "urls" => [
                    "https://www.leafly.com/indica/shishkaberry?q=shishkaberry&cat=strain",
                    "https://www.leafly.com/products/details/genesis-pharms-shishkaberry?q=shishkaberry&cat=product",
                    "https://www.leafly.com/products/details/emerald-health-therapeutics-shishkaberry?q=shishkaberry&cat=product",
                    "https://www.leafly.com/products/details/redecan-shishkaberry?q=shishkaberry&cat=product",
                    "https://www.leafly.com/products/details/weedmd-shishkaberry-clone?q=shishkaberry&cat=product",
                    "https://www.leafly.com/products/details/seven-oaks-shiskaberry?q=shishkaberry&cat=product"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/beleave-shishkaberry",
                "lift_vendor" => "Beleave",
                "lift_thc" => "17",
                "lift_cbd" => "0.1",
                "lift_des" => "An Indica-dominant hybrid that came from crossing DJ Short Blueberry with an unknown Afghani strain. Shiskaberry's buds have a fruit and berry aroma with shades of purple.",
                "lift_flavors" => "berry, fruity, earthy",
                "lift_badeffects" => ["red eyes" => "93.3333", "coughing" => "100"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["insomnia" => "33.3333", "anxiety" => "36.6667"]
            ],[
                "lift_url" => "https://lift.co/strains/weedmd-shishkaberry",
                "lift_vendor" => "WeedMD",
                "lift_thc" => "15.2",
                "lift_cbd" => "0",
                "lift_des" => "Shishkaberry, is an indica-dominant hybrid that came about from crossing DJ Short Blueberry with an unknown Afghani strain. Shishkaberry�s buds have a fruit and berry aroma and will be painted with shades of purple.",
                "lift_flavors" => "berry, fruity, blueberry",
                "lift_badeffects" => ["dry mouth" => "71.6667", "coughing" => "95"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["depression" => "6.66667", "stress" => "11.6667", "insomnia" => "21.6667", "anxiety" => "25", "pain" => "30"]
            ]
        ],
        "solar-power" => [
            "lift_url" => "https://lift.co/strains/symbl-solar-power",
            "lift_vendor" => "Symbl",
            "lift_thc" => "21",
            "lift_cbd" => "0",
            "lift_des" => "AKA�Sour Kush, this Symbl hybrid has a tightly packed bud structure with dense, vibrant green flowers covered with amber pistils and sprinkled with frosty trichomes. Terrifically tart and superbly pungent, Sour Kush is known for its powerful flavour profile combining sour, crisp lemon and invigorating pine. The robust, tangy citrus taste is balanced with hints of earthy wood and sharp diesel.",
            "lift_flavors" => "earthy, citrus, pine",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["happy" => "28.3333", "energetic" => "46.6667", "giggly" => "53.3333", "relaxed" => "53.3333", "awake" => "61.6667"],
            "urls" => [
                "https://www.leafly.com/products/details/symbl-cannabis-solar-power?q=solar-power&cat=product",
                "https://www.leafly.com/products/details/ahlot-symbl?q=solar-power&cat=product"
            ]
        ],
        "sunset" => [
            "lift_url" => "https://lift.co/strains/lbs-sunset",
            "lift_vendor" => "LBS",
            "lift_thc" => "17",
            "lift_cbd" => "12",
            "lift_des" => "",
            "lift_flavors" => "earthy, flowery, sweet",
            "lift_badeffects" => ["bad taste" => "58.3333", "lazy" => "61.6667", "hungry" => "75"],
            "lift_goodeffects" => ["euphoric" => "28.3333", "sleepy" => "43.3333", "calming" => "45", "relaxed" => "45", "happy" => "61.6667"],
            "urls" => [
                "https://www.leafly.com/products/details/lbs-sunset?q=sunset&cat=product",
                "https://www.leafly.com/products/details/lbs-sunset-25-mg-capsules?q=sunset&cat=product"
            ]
        ],
        "super-skunk" => [
            "lift_url" => "https://lift.co/strains/united-greeneries-super-skunk",
            "lift_vendor" => "United Greeneries",
            "lift_thc" => "16.1",
            "lift_cbd" => "0",
            "lift_des" => "This indica dominant hybrid is derived from Skunk #1 and Afghani genetics.�Proudly cultivated on Vancouver Island in British Columbia.PercentagesTHC: 16.1%CBD: 0.00%Dominant Terpene ProfileCaryophyllene (spicy, black pepper)Myrcene (herbal, woody)Alpha Pinene (fresh, piney, sweet)�",
            "lift_flavors" => "skunk, spicy/herbal, skunky",
            "lift_badeffects" => ["hungry" => "20", "red eyes" => "65"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["stress" => "20", "headaches" => "28.3333", "anxiety" => "30", "back pain" => "36.6667", "pain" => "38.3333"],
            "urls" => [
                "https://www.leafly.com/indica/super-skunk?q=super-skunk&cat=strain",
                "https://www.leafly.com/products/details/royal-high-super-skunk?q=super-skunk&cat=product"
            ]
        ],
        "super-sonic" => [
            "lift_url" => "https://lift.co/strains/symbl-super-sonic",
            "lift_vendor" => "Symbl",
            "lift_thc" => "17",
            "lift_cbd" => "0",
            "lift_des" => "AKA�Quantum Kush, it�s a tall-growing sativa that has fairly dense, olive green buds speckled with a flecks of rusty red and a lush coating of frosty trichomes. Don�t be misguided by the common name; unlike most Kush strains, this one is most definitely sativa-dominant. Super Sonic has a classic, yet complex earthy, sweet aroma that�s pleasantly pungent, coupled with a sumptuous tropical taste.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => [
                "https://www.leafly.com/products/details/symbl-cannabis-super-sonic?q=super-sonic&cat=product"
            ]
        ],
        "tangerine-dream" => [
            [
                "lift_url" => "https://lift.co/strains/canna-farms-tangerine-dream",
                "lift_vendor" => "Canna Farms",
                "lift_thc" => "17.6",
                "lift_cbd" => "0.1",
                "lift_des" => "The Tangerine Dream is a true delight. �A combination of G13, Afghani and Neville's Haze brings you a Sativa dominant strain that energizes you while working to knock out pain and relax muscles. Combat your stress and anxiety and uplifted throughout your day..�One taste of the Tangerine will feel like a Dream!",
                "lift_flavors" => "citrus, orange, fruity",
                "lift_badeffects" => ["nothing" => "45", "giggly" => "48.3333"],
                "lift_goodeffects" => ["tasteful" => "18.3333", "anxiety" => "30", "giggly" => "43.3333", "calming" => "43.3333", "social" => "45"],
                "urls" => [
                    "https://www.leafly.com/hybrid/tangerine-dream?q=tangerine-dream&cat=strain",
                    "https://www.leafly.com/products/details/canna-farms-tangerine-dream?q=tangerine-dream&cat=product",
                    "https://www.leafly.com/products/details/phyto-extractions-tangerine-dream?q=tangerine-dream&cat=product",
                    "https://www.leafly.com/products/details/san-rafael-71-tangerine-dream?q=tangerine-dream&cat=product"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/san-rafael-71-tangerine-dream",
                "lift_vendor" => "San Rafael 71",
                "lift_thc" => "16.2",
                "lift_cbd" => "0",
                "lift_des" => "Tangerine Dream is a high THC sativa strain highlighted by a citrus aroma along with an unmistakable, purple hue. This dried flower is made up of purple and green buds that are fairly dense, but break up easily when handled.�\n",
                "lift_flavors" => "citrus, orange, citrusy",
                "lift_badeffects" => ["forgetful" => "61.6667", "dry eyes" => "71.6667", "coughing" => "75"],
                "lift_goodeffects" => ["tasteful" => "21.6667", "happy" => "38.3333", "giggly" => "45", "focused" => "46.6667", "uplifted" => "46.6667"]
            ],[
                "lift_url" => "https://lift.co/strains/whistler-medical-marijuana-tangerine-dream",
                "lift_vendor" => "Whistler Medical Marijuana",
                "lift_thc" => "19.6",
                "lift_cbd" => "0.1",
                "lift_des" => "This winner of the 2010 Cannabis Cup was created by the illustrious Barney�s Farm. A strain for connoisseurs, Tangerine Dream is the hybrid daughter of�G13�and Neville�s breeder strain A5. Its ability to knock out pain while increasing energy is what makes Tangerine Dream so special. While too much Tangerine Dream may leave you stuck on the couch, this strain was handcrafted to meet the demands of working medical patients. Uplifting and euphoric, it provides users with mental clarity while deeply relaxing muscles. Tangerine Dream typically flowers in 8 to 10 weeks and features a citrusy aroma.",
                "lift_flavors" => "citrus, orange, sweet",
                "lift_badeffects" => ["dry mouth" => "56.6667"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["depression" => "36.6667", "insomnia" => "46.6667", "anxiety" => "55", "pain" => "55", "stress" => "60"]
            ]
        ],
        "temple" => [
            "lift_url" => "https://lift.co/strains/aurora-recreational-temple",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "1",
            "lift_cbd" => "14",
            "lift_des" => "A high CBD, low-THC, hybrid strain with an earthy, pine aroma with undertones of crushed grape. Aurora�s Temple is made up of smaller, dark green buds with hints of purple and navy, accented by orange pistil hairs.",
            "lift_flavors" => "earthy, sweet",
            "lift_badeffects" => ["bad taste" => "80"],
            "lift_goodeffects" => ["calming" => "58.3333", "relaxed" => "60", "awake" => "75"]
        ],
        "ultra-sour" => [
            [
                "lift_url" => "https://lift.co/strains/zenabis-ultra-sour",
                "lift_vendor" => "Zenabis",
                "lift_thc" => "22.3",
                "lift_cbd" => "0.1",
                "lift_des" => "",
                "lift_flavors" => "sour, citrusy, diesel",
                "lift_badeffects" => ["cough" => "86.6667"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["depression" => "28.3333", "anxiety" => "46.6667"],
                "urls" => [
                    "https://www.leafly.com/products/details/seven-oaks-ultra-sour?q=ultra-sour&cat=product",
                    "https://www.leafly.com/products/details/namaste-ultra-sour?q=ultra-sour&cat=product",
                    "https://www.leafly.com/sativa/ultra-sour?q=ultra-sour&cat=strain"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/weedmd-ultra-sour",
                "lift_vendor" => "WeedMD",
                "lift_thc" => "21.2",
                "lift_cbd" => "0.1",
                "lift_des" => "Ultra Sour is a high THC Sativa Dominant strain that is a cross of Mk Ultra x East Coast Sour D. With its sour taste and aroma of mint and earthy flavours, it is a great strain to add flavour to your taste buds. The inflorescences (buds) are deep green in colour with dark orange pistils.",
                "lift_flavors" => "sour, diesel, citrus",
                "lift_badeffects" => ["dry eyes" => "61.6667", "dry mouth" => "63.3333"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["pain" => "16.6667", "concentration" => "20", "anxiety" => "33.3333", "mood" => "36.6667", "stress" => "38.3333"]
            ]
        ],
        "unplug" => [
            "lift_url" => "https://lift.co/strains/solei-unplug",
            "lift_vendor" => "Solei",
            "lift_thc" => "24.7",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => [],
            "urls" => [
                "https://www.leafly.com/products/details/solei-unplug?q=unplug&cat=product",
                "https://www.leafly.com/products/details/solei-unplug-oil?q=unplug&cat=product",
                "https://www.leafly.com/products/details/solei-unplug-pre-roll?q=unplug&cat=product"
            ]
        ],
        "wappa" => [
            [
                "lift_url" => "https://lift.co/strains/redecan-wappa",
                "lift_vendor" => "Redecan",
                "lift_thc" => "20",
                "lift_cbd" => "1",
                "lift_des" => "",
                "lift_flavors" => "earthy, fruity",
                "lift_badeffects" => [],
                "lift_goodeffects" => ["relaxed" => "26.6667", "happy" => "33.3333", "calming" => "35", "sleepy" => "53.3333"],
                "urls" => [
                    "https://www.leafly.com/products/details/redecan-wappa?q=wappa&cat=product",
                    "https://www.leafly.com/products/details/7-acres-7acres-wappa?q=wappa&cat=product",
                    "https://www.leafly.com/products/details/redecan-wappa-drops?q=wappa&cat=product",
                    "https://www.leafly.com/hybrid/wappa?q=wappa&cat=strain"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/zenabis-wappa",
                "lift_vendor" => "Zenabis",
                "lift_thc" => "18",
                "lift_cbd" => "0.1",
                "lift_des" => "Wappa is an indica-dominant hybrid that has a vibrant frosty lime colored appearance with a medley of amber stigmas. With an impressive trichome-rich, dense structure, Wappa stands out as a truly unique variety. With high levels of THC, new patients should be cautious and remember to start with low doses.",
                "lift_flavors" => "",
                "lift_badeffects" => [],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["anxiety" => "45"]
            ],[
                "lift_url" => "https://lift.co/strains/redecan-pharm-wappa",
                "lift_vendor" => "RedeCan Pharm",
                "lift_thc" => "22.8",
                "lift_cbd" => "0.3",
                "lift_des" => "",
                "lift_flavors" => "fruity, earthy, sweet",
                "lift_badeffects" => ["dry mouth" => "60", "dry eyes" => "70", "coughing" => "86.6667"],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["stress" => "20", "lack of appetite" => "25", "headaches" => "26.6667", "anxiety" => "28.3333", "pain" => "33.3333"]
            ]
        ],
        "white-shark" => [
            [
                "lift_url" => "https://lift.co/strains/weedmd-white-shark",
                "lift_vendor" => "WeedMD",
                "lift_thc" => "16.1",
                "lift_cbd" => "0",
                "lift_des" => "White Shark is a Sativa dominant strain which has won the High Times Cannabis Cup in 1997 for best Hybrid. White Shark is a cross between Super Skunk x Brazilian x South Indian. Super Skunk is an Indica dominant strain while Brazilian and South Indian are Sativa dominant. White Shark shows characteristics from both a Sativa and an Indica. The inflorescences (buds) are dense, light green and express subtle golden hues. The aroma consists of notes of pine, lemon and complimentary grape undertones. ",
                "lift_flavors" => "dank, earthy, lemon",
                "lift_badeffects" => ["hungry" => "46.6667", "dry eyes" => "61.6667", "dry mouth" => "65"],
                "lift_goodeffects" => ["relaxed" => "15", "uplifted" => "16.6667", "sleepy" => "20", "euphoric" => "30", "energetic" => "31.6667"],
                "urls" => [
                    "https://www.leafly.com/products/details/weedmd-white-shark?q=white-shark&cat=product",
                    "https://www.leafly.com/products/details/redecan-white-shark?q=white-shark&cat=product"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/redecan-pharm-white-shark",
                "lift_vendor" => "RedeCan Pharm",
                "lift_thc" => "20.4",
                "lift_cbd" => "0",
                "lift_des" => "Cross Between: Super Skunk x Brazilian & South Indian Strains 85%/15%",
                "lift_flavors" => "earthy",
                "lift_badeffects" => [],
                "lift_goodeffects" => [],
                "lift_symptoms" => ["insomnia" => "33.3333", "depression" => "36.6667", "anxiety" => "61.6667"]
            ]
        ],
        "white-widow" => [
            [
                "lift_url" => "https://lift.co/strains/canaca-white-widow",
                "lift_vendor" => "Canaca",
                "lift_thc" => "1.1 mg/ml",
                "lift_cbd" => "0 mg/ml",
                "lift_des" => "",
                "lift_flavors" => "mild",
                "lift_badeffects" => [],
                "lift_goodeffects" => ["relaxed" => "50"],
                "urls" => [
                    "https://www.leafly.com/hybrid/white-widow?q=white-widow&cat=strain",
                    "https://www.leafly.com/products/details/mainland-cannabis-white-widow?q=white-widow&cat=product",
                    "https://www.leafly.com/products/details/weedup-white-widow?q=white-widow&cat=product",
                    "https://www.leafly.com/products/details/redecan-white-widow?q=white-widow&cat=product"
                ]
            ],[
                "lift_url" => "https://lift.co/strains/7acres-white-widow",
                "lift_vendor" => "7Acres",
                "lift_thc" => "20",
                "lift_cbd" => "1",
                "lift_des" => "White Widow has earned its place as a multiple award-winning Cultivar with widespread consumer appeal. Since its birth in 1994, White Widow has been known for being highly resinous, it�s name was made in reference to the visually prominent white coating of trichomes the strain produces.White Widow is a highly resinous, balanced hybrid with a pungent, sweet and woody aroma.",
                "lift_flavors" => "earthy",
                "lift_badeffects" => [],
                "lift_goodeffects" => ["uplifted" => "60", "calming" => "70"]
            ],[
                "lift_url" => "https://lift.co/strains/redecan-white-widow",
                "lift_vendor" => "Redecan",
                "lift_thc" => "20",
                "lift_cbd" => "1",
                "lift_des" => "",
                "lift_flavors" => "earthy, citrus",
                "lift_badeffects" => ["dry mouth" => "66.6667", "cough" => "95"],
                "lift_goodeffects" => ["relaxed" => "16.6667", "energetic" => "38.3333", "focused" => "41.6667", "calming" => "46.6667", "creative" => "46.6667"]
            ]
        ],
        "yin-yang" => [
            "lift_url" => "https://lift.co/strains/liiv-yin-yang",
            "lift_vendor" => "liiv",
            "lift_thc" => "10",
            "lift_cbd" => "13",
            "lift_des" => "This indica-dominant hybrid is beautifully balanced. Descending from the famous Harlequin and Jack the Ripper strains, its purple-fringed buds feature orange touches, with pink and yellow undertones. The pungent, woody aroma, dotted with notes of sweet herbs, coffee and black pepper, builds on a delicious pine foundation.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["happy" => "38.3333", "calming" => "56.6667", "relaxed" => "61.6667", "focused" => "66.6667"],
            "urls" => [
                "https://www.leafly.com/products/details/liiv-yin-yang?q=yin-yang&cat=product",
                "https://www.leafly.com/products/details/liiv-yin-yang-pre-rolls?q=yin-yang&cat=product"
            ]
        ]
    ];


/*
$data = file_get_cookie_contents_ocs("GET", "https://cdn.shopify.com/s/files/1/2636/1928/products/http-52-60-121-34-upload-100211-00841464000065-a1c1-c01_1024x1024.png", false, false, "_y=c544ae2d-8E9C-4201-D3D0-383ABAC540ED; _shopify_y=c544ae2d-8E9C-4201-D3D0-383ABAC540ED; _s=c544ae36-0C0B-4F2A-EBDD-35479E9DA03E; _shopify_s=c544ae36-0C0B-4F2A-EBDD-35479E9DA03E; _shopify_fs=2019-02-07T00%3A03%3A57.142Z; _fbp=fb.1.1549497837440.241724310", false, [
    "Accept" => " text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*" . "/*;q=0.8",
    "Accept-Encoding" => "gzip, deflate, br",
    "if-modified-since" => "Wed, 06 Feb 2019 23:29:50 GMT",
    "Referer" => false,
    "Connection" => false,
    "Host" => false,
    "If-None-Match" => false
]);
vardump($data);
die();
*/

?>
<link rel="stylesheet" type="text/css" href="<?= $this->webroot; ?>css/style.css"/>
<SCRIPT>
    function bottom(){
        window.scrollTo(0,document.body.scrollHeight);
    }
</SCRIPT>
<STYLE>
    .parent{
        position: relative;
        top: -9px;
        width: 100%;
        min-width: 100px;
    }
    .progress{
        background-color: lightblue;
        position: absolute;
        left: 0;
        top: 0;
        height: 18px;
        z-index: 1;
    }
    .indicator{
        width: 100%;
        text-align: center;
        z-index: 20;
        color: red;
        position: absolute;
        left: 0;
        top: 0;
        height: 18px;
    }
</STYLE>
<TABLE WIDTH="100%">
    <TR>
        <TD>
<?php
    function is_item_array($array){
        foreach($array as $key => $value){
            if(!is_numeric($key)){
                return true;
            }
        }
        return false;
    }

    function purge($text = "", $bottom = true){
        if($bottom){$text .= '<SCRIPT>bottom();</SCRIPT>';}
        if($text){echo $text;}
        flush();
        if( ob_get_level() > 0 ){ob_flush();}
    }

    function table_has_column($tablename, $column, $type = false, $null = false, $default = false, $after = false, $isprimarykey = false, $comment = false){
        $tables = describe($tablename);
        foreach($tables as $table){
            if($table["Field"] == $column){
                return true;
            }
        }
        if($type) {
            $SQL = "ALTER TABLE " . $tablename . " ADD COLUMN " . $column . " " . $type;
            if (!$null) {
                $SQL .= " NOT NULL";
            }
            if($default !== false){
                if(is_numeric($default)){
                    $SQL .= " DEFAULT " . $default;
                } else {
                    $SQL .= " DEFAULT '" . $default . "'";
                }
            }
            if ($isprimarykey) {
                $SQL .= " AUTO_INCREMENT PRIMARY KEY";
            }
            if($comment){
                $SQL .= " COMMENT '" . $comment . "'";
            }
            if ($after === true) {
                $SQL .= " FIRST";
            } else if ($after) {
                $SQL .= " AFTER " . $after;
            }
            query($SQL);
            echo "<BR>Created " . $column . " (" . $type . ") column in " . $tablename;
        }
    }

    function trimleft($Text, $Startingtext, $isStart = true){
        $start = strpos($Text, $Startingtext);
        if($start !== false) {
            if($isStart) {
                return right($Text, strlen($Text) - $start);
            }
            return left($Text, $start);
        }
        return $Text;
    }

    function file_get_cookie_contents_ocs($method = "GET", $URL, $querydata = false, $POSTdata = false, $Cookie = false, $isGZIP = true, $HEADERS = false){
        $headers = [
            'Referer' =>  			'https://ocs.ca/collections/1-gram-packs-of-cannabis?page=4&hitsPerPage=12',
            'Accept' => 			'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Encoding' => 	'gzip',
            'Accept-Language' => 	'en-US,en;q=0.9',
            'Cache-control'	=>		'max-age=0',
            'Connection' => 		'keep-alive',
            'Host' => 				'ocs.ca',
            'User-Agent' => 		'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
            'If-None-Match' =>		'cacheable:b2a12efabf26cf0744bfd308dc9e7d5d',
            'Upgrade-Insecure-Requests' => 1
        ];
        if(is_array($HEADERS)){
            foreach($HEADERS as $KEY => $VALUE){
                if($VALUE) {
                    $headers[$KEY] = $VALUE;
                } else {
                    unset($headers[$KEY]);
                }
            }
        }
        if(is_array($Cookie)){
            $header = $Cookie;
            $Cookie = "";
            foreach($header as $key => $value){
                $Cookie .= $key . "=" . $value . "; ";
            }
            $Cookie = trim($Cookie);
        }
        $header = "";
        foreach($headers as $key => $value){
            $header .= $key . ": " . $value . "\r\n";
        }
        $header .= "Cookie: " . $Cookie . "\r\n";
        $method = trim(strtoupper($method));
        if($method == "GET"){
            $opts = array('http'=>array('method'=>"GET",'header'=> $header));
        } else {
            $opts = array('http'=>array('method'=>"POST",'header'=> $header,'content' => $POSTdata));
        }
        $context = stream_context_create($opts);
        if(is_array($querydata)){
            $dilimiter = "?";
            foreach($querydata as $KEY => $VALUE){
                $URL .= $dilimiter . $KEY . "=" . urlencode($VALUE);
                $dilimiter = "&";
            }
        }
        try{
            $DATA = file_get_contents($URL, false, $context);
            if($isGZIP) {
                return gzdecode($DATA);
            }
            return $DATA;
        } catch (Exception $e){
            return $URL . " failed";
        }
    }

    function decode($HTML){
        $HTML = htmlentities($HTML);
        $HTML = str_replace("\/", "/", $HTML);
        $nextletter = 0;
        for($i = strlen($HTML) - 1; $i > -1; $i--){
            $letter = ord(mid($HTML, $i, 1));
            if($nextletter == 34 && $letter == 92){
                $HTML = left($HTML, $i-1) . right($HTML, strlen($HTML) - $i - 2);
            }
            $nextletter = $letter;
        }
        return $HTML;
    }

    function json_decode2($TEXT){
        $JSON = json_decode($TEXT, true);
        if(is_array($JSON) && $JSON){
            return $JSON;
        }
        $TEXT = decode($TEXT);
        $one = '"https://ocs.ca/collections/1-gram-packs-of-cannabi]"';
        $two = '"https://ocs.ca/collections/tous-les-produit]"';
        $TEXT = str_replace([$one, $two], ['"links": [' . $one, $two . "],"], $TEXT);
        return json_decode($TEXT, true);
    }

    function getbetween2($TEXT, $START, $END){
        return getbetween($TEXT, htmlspecialchars($START), htmlspecialchars($END));
    }

    function extractdata($productname){//https://ocs.ca/products/blue-dream-pre-roll
        global  $Cookie;
        $productname = str_replace(" ", "-", strtolower($productname));
        $URL = "https://ocs.ca/products/" . $productname;
        $HTML = file_get_cookie_contents_ocs("GET", $URL, false, false, $Cookie);
        //$HTML2 = htmlspecialchars($HTML);
        $data = json_decode2(getbetween($HTML, '<script type="application/ld+json">', '</script>'));
        $data["shorttext"] 	= decode(getbetween($HTML, '<p data-full-text="', '" >'));
        $data["price"] 	= getbetween($HTML, '<h2 class="product__price">', '</h2>');
        $data["URL"] = $URL;

        $tabledata = getbetween($HTML, '<table id="product__properties-table" class="table--striped product__properties-table">', '</table>');
        $tabledata = explode('</tr>', $tabledata);
        foreach($tabledata as $INDEX => $cells){
            $cells = explode('</td>', trim($cells));
            foreach($cells as $ID => $cell){
                $cells[$ID] = trim(strip_tags($cell));
            }
            $tabledata[$INDEX] = array_filter($cells);
            if(isset($tabledata[$INDEX][0]) && $tabledata[$INDEX][0]){
                $KEY = $tabledata[$INDEX][0];
                $VALUE = $tabledata[$INDEX][1];
                switch($KEY){
                    case "GTIN#": break;
                    case "Terpenes":
                        $data["Terpenes"] = explode(",\n", str_replace("  ", "", $VALUE));
                        break;
                    default: $data[$KEY] = $VALUE;
                }
            }
        }
        $HTML2 = getbetween($HTML, 'window.theme.product_json =', ';');
        $data2 = json_decode2($HTML2);
        if(is_array($data2)){
            $data = array_merge($data, $data2);
        } else {
            $data["Missing"] = $HTML2;
        }
        $images = explode('</div>', getbetween($HTML, '<div class="product-images__carousel">', '</div></div>'));
        foreach($images as $INDEX => $HTML){
            $HTML = trim(str_replace('<div class="product-images__slide">', '', $HTML));
            $images[$INDEX] = "https:" . getbetween($HTML, '<img src="', '"');
        }
        $data["images"] = $images;
        return $data;
    }

    function enumstrains($collection, $page = -1){
        global $Cookie;
        if($collection == "hardcoded"){
            $HTML = ["kinky-kush"];//, "delahaze"];
        } else {
            $URL = "https://ocs.ca/collections/" . $collection;
            if ($page > 0) {
                $URL .= '?page=' . $page . '&hitsPerPage=12';
            }
            $HTML = html_entity_decode(file_get_cookie_contents_ocs("GET", $URL, false, false, $Cookie));
            $products = getbetween($HTML, '<div class="collection__count hidden-mobile"><span>', '</span>');
            $itemsperpage = 12;
            $pages = ceil($products / $itemsperpage);
            $HTML = explode('<a href="/products/', $HTML);
            foreach ($HTML as $ID => $VAL) {
                $VAL = strip_tags(getbetween('<a href="' . $VAL, '<a href="', '"'));
                $VAL = trim(str_replace("\\n", "\n", $VAL));
                $HTML[$ID] = $VAL;
            }
            if ($page == -1) {//getall
                for ($page = 1; $page < $pages; $page++) {
                    $HTML = array_merge($HTML, enumstrains($collection, $page));
                }
            }
        }
        $HTML = array_values(array_unique(array_filter($HTML)));
        sort($HTML);
        return $HTML;
    }

    foreach($_GET as $key => $value){
        $$key = $value;
    }

    function getme(){
        $me = first("SELECT * FROM users WHERE email='roy@trinoweb.com'");
        if($me) {
            $me = $me["id"];
        } else {
            $me = [
                "username"  => "tahiri",
                "email"     => "roy@trinoweb.com",
                "password"  => "511e15842eb41df50d55b710d9c9652b",
                "user_type" => 1,
                "country"   => "Canada"
            ];
            $me = insertdb("users", $me);
        }
        return $me;
    }

    function getstrain($slug){
        return first("SELECT * FROM strains WHERE slug='" . $slug . "'");
    }

    function trimend2($Text, $Trim){
        if(endswith(strtolower($Text), strtolower($Trim)) ){
            $Text = left($Text, strlen($Text) - strlen($Trim));
        }
        return trim($Text);
    }

    function cleanslug($slug = "lemon-skunk-capsules-2-5mg"){
        if(!is_array($slug)){$slug = explode("-", strtolower($slug));}
        $last = end($slug);
        if(is_numeric($last)){
            unset($slug[count($slug) - 1]);//bakerstreet-capsules-2-5mg
            $last = end($slug);
        }
        if (endswith($last, "mg") && is_numeric(left($last, strlen($last) - 2))) {
            unset($slug[count($slug) - 1]);//bakerstreet-capsules-2-5mg
            if(count($slug) > 1 && is_numeric($slug[count($slug) - 1])){
                unset($slug[count($slug) - 1]);
            }
        }
        $wordstoremove = ["oil", "oral", "spray", "mct", "thc", "peppermint", "capsules", "pre", "roll", "pack", "canaca", "sativa", "redecan", "woodstock", "symbl", "cbd"];
        $last = count($slug) - 1;
        foreach(array_reverse($slug) as $index => $word){
            $index = $last - $index;
            if(in_array(strtolower($word), $wordstoremove) || is_numeric($word)){
                unset( $slug[$index] );
            } else {
                break;
            }
        }
        $slug = implode("-", $slug);
        $vendors = ["Alta Vie", "San Rafael", "Haven St", "roll pack"];
        foreach($vendors as $vendor){
            $slug = trimend2($slug, "-" . str_replace(" ", "-", strtolower($vendor)));
        }
        return $slug;
    }

    function fromclassname($slug){
        $slug = explode("-", $slug);
        foreach($slug as $KEY => $VALUE){
            $slug[$KEY] = ucfirst($VALUE);
        }
        return trim(implode(" ", $slug));
    }

    function handleeffect($name, $negative = 0){
        $data = first("SELECT * FROM effects WHERE title='" . $name . "'");
        if (!$data) {
            $data = ["title" => $name, "imported" => 2, "negative" => $negative];
            $data["id"] = insertdb('effects', $data);
        }
        return $data;
    }

    function cleanname($name){
        return trimend(trim(trimend(trimend2($name, "pre-roll"), "(")), "Â");
    }

    function import($strain, $JSONdata, $me, $types, $collection, $options, $extradata, $negativeeffects, $dir) {
        global $Cookie;
        $tags = [];
        $strain2 = false;
        $originalstrain = $strain;
        if (is_array($JSONdata)) {
            $localstrain = getstrain($strain);
            $mergeprices = false;

            //add new effects
            if (isset($JSONdata["tags"])) {
                foreach ($JSONdata["tags"] as $tag) {
                    if (startswith($tag, "effect--")) {
                        $tag = right($tag, strlen($tag) - 8);
                        $tags[$tag] = handleeffect($tag);
                    }
                }
            }

            if (!$localstrain) {
                $strain2 = cleanslug($strain);
                //echo " [BEFORE: " . $strain . "][AFTER: " . $strain2 . ']';
                if ($strain2 && $strain2 != $strain) {
                    $localstrain = getstrain($strain2);
                    $mergeprices = true;
                    $strain = $strain2;
                }
            }

            //add new strain
            if ($localstrain) {//update it
                if (!isset($localstrain["hasocs"]) || $localstrain["hasocs"] == 0) {
                    insertdb("strains", ["id" => $localstrain["id"], "hasocs" => 1]);
                }
            } else if (is_array($JSONdata) && isset($JSONdata["title"]) && isset($JSONdata["content"])) {//create it
                if($options["makenewstrains"]) {
                    $plant = explode(" ", $JSONdata["Plant"]);
                    $plant = $plant[0];
                    //if(endswith($JSONdata["title"], ""))
                    $localstrain = [
                        "hasocs"        => 1,
                        "type_id"       => getiterator($types, "title", $plant)["id"],
                        "name"          => cleanname($JSONdata["title"]),
                        "description2"  => $JSONdata["content"],
                        "slug"          => $strain,
                        "imported"      => "2"//0=native, 1=leafly, 2=ocs
                    ];
                    if ($localstrain["name"] && $localstrain["description2"]) {
                        $localstrain["id"] = insertdb("strains", $localstrain);
                    } else {
                        return "Error, name or description were blank";
                    }
                } else {
                    return "Skipped, makenewstrains=false";
                }
            } else {
                return false;
            }

            if (isset($localstrain["id"]) && $localstrain["id"]) {
                $ocsdata = false;// first("SELECT * FROM ocs WHERE strain_id=" . $localstrain["id"]);
                if (!$ocsdata && isset($JSONdata["content"])) {//add to ocs table
                    if (!isset($JSONdata["Terpenes"]) || !is_array($JSONdata["Terpenes"])) {
                        $JSONdata["Terpenes"] = [];
                    }
                    $ocsdata = [
                        "slug"      => $originalstrain,
                        "category"  => $JSONdata["type"],
                        "strain_id" => $localstrain["id"],
                        "shorttext" => $JSONdata["shorttext"],
                        "price"     => $JSONdata["price"],
                        "plant"     => $JSONdata["Plant"],
                        "terpenes"  => implode(", ", $JSONdata["Terpenes"]),
                        "content"   => $JSONdata["content"],
                        "available" => $JSONdata["available"] == "true",
                        "ocs_id"    => $JSONdata["id"],
                        "ocs_thc"   => $JSONdata["thc"],
                        "ocs_cbd"   => $JSONdata["cbd"]
                    ];
                }

                $prices = [];
                if ($mergeprices && isset($ocsdata["prices"]) && isJSON($ocsdata["prices"])) {
                    $prices = json_decode($ocsdata["prices"], true);
                }
                if (isset($JSONdata["variants"])) {
                    foreach ($JSONdata["variants"] as $variant) {
                        $data = [//data to be included in prices JSON
                            "price" =>      $variant["price"],
                            "slug" =>       $originalstrain,
                            "title" =>      $variant["public_title"],
                            "category" =>   $collection,
                            "vendor" =>     $JSONdata["vendor"]
                        ];
                        if($data["title"] === null){
                            $data["title"] = $variant["title"];
                        }
                        if($data["title"] == "Default Title"){
                            $data["title"] = $variant["name"];
                        }
                        $prices[] = $data;
                    }
                    $ocsdata["prices"] = json_encode($prices);
                }

                $JSONdata["downloadedimages"] = 0;
                $JSONdata["skippedimages"] = 0;
                if (isset($JSONdata["images"]) && false) {
                    foreach ($JSONdata["images"] as $INDEX => $URL) {
                        $filename = $dir . $originalstrain . "-" . $INDEX . "." . getextension2($URL);
                        $dir2 = left($dir, strlen($dir) - 4) . "/images/strains/" . $localstrain["id"];
                        if(!is_dir($dir2)){
                            mkdir($dir2);
                        }
                        $actualfilename = $dir2 . "/" . $originalstrain . "-" . $INDEX . "." . getextension2($URL);
                        if(file_exists($filename)) {
                            $JSONdata["skippedimages"] += 1;
                            rename($filename, $actualfilename);
                        } else if(file_exists($actualfilename)) {
                            $JSONdata["skippedimages"] += 1;
                        } else {
                            //$DATA = file_get_contents("GET", $URL, false, false, $Cookie);
                            $DATA = file_get_contents($URL);
                            if($DATA) {
                                file_put_contents($actualfilename, $DATA);
                                $JSONdata["downloadedimages"] += 1;
                            } else {
                                die( $URL . " FAILED TO DOWNLOAD" );
                            }
                        }
                    }
                }

                if(isset($extradata[$strain])){
                    $data = $extradata[$strain];
                    if(is_item_array($data)){$data = [$data];}
                    //wanted:       lift and leafly: link, description, thc, cbd
                    //OCS table:    lift_url (TEXT), lift_description (TEXT), lift_thc (VARCHAR 16), lift_cbd (VARCHAR 16)
                    //data:         lift_url, lift_vendor, lift_thc, lift_cbd, lift_des, lift_flavors, lift_effects (combined, use $negativeeffects to compare) OR lift_badeffects AND lift_goodeffects, urls (leafly, array)
                    $URLs = [];
                    $ocsdata["lift_des"] = "";
                    $ocsdata["lift_thc"] = "0";
                    $ocsdata["lift_cbd"] = "0";
                    foreach($data as $cell){
                        $URLs[] = ["vendor" => $cell["lift_vendor"], "url" => $cell["lift_url"]];
                        foreach(["lift_des", "lift_thc", "lift_cbd"] as $column){
                            if($ocsdata[$column] == "0" && strlen($cell[$column]) > 0){
                                $ocsdata[$column] = $cell[$column];
                            }
                        }
                    }
                    //handle effects, symptoms, flavors
                    $ocsdata["lift_url"] = json_encode($URLs);
                }

                insertdb("ocs", $ocsdata);
                $localstrain["ocsdata"] = $localstrain;
                if ($mergeprices) {
                    $localstrain["mergedwith"] = $strain2;
                }
                return array_merge($JSONdata, $localstrain);
            }
        }
        return false;
    }


    table_has_column("strains", "hasocs", "TINYINT(4)");
    table_has_column("reviews", "activitiescount", "INT(11)");
    table_has_column("reviews", "activities", "VARCHAR(2048)");

    set_time_limit(0);
    $collections = ["hardcoded", "dried-flower-cannabis", "pre-rolled", "oils-and-capsules"];
    purge('<BR>Downloading all: ' . implode(", ", $collections));
    $dir = getcwd() . "/ocs";
    if(!is_dir($dir)){
        mkdir($dir, 0777);
    }
    $dir .= "/";

    $forceupdate = true;//set to true to forcefully update the JSON from the site
    $Cookie = "_shopify_y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _orig_referrer=https%3A%2F%2Fwww.google.ca%2F; secure_customer_sig=; _landing_page=%2F; cart_sig=; _y=81cab18d-8927-4e0e-bc4e-0e16f1f46cdc; _s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_s=522fd587-BFB4-4F82-3871-6CB32CBB9150; _shopify_fs=2019-01-15T15%3A44%3A52.677Z; _shopify_sa_p=; _ga=GA1.2.49790356.1547567094; _gid=GA1.2.1293338108.1547567094; _age_validated=true; _shopify_sa_t=2019-01-15T16%3A13%3A03.593Z";
    $me = getme();
    if(!enum_tables("activities")) {
        Query("CREATE TABLE `activities` (`id` int(11) NOT NULL AUTO_INCREMENT, `title` varchar(255) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB");
        $activities = ["Hiking", "Exercise", "Music", "Video Games", "Cleaning", "Yoga", "Meditation", "Movies", "Study", "Reading", "Working"];
        sort($activities);
        foreach($activities as $activity){
            insertdb("activities", ["title" => $activity, "imported" => 2]);
        }
        purge('<BR>activities table created and filled with (' . implode(", ", $activities) . ")");
    }
    if(!enum_tables("activity_ratings")) {
        Query("CREATE TABLE `activity_ratings` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL, `review_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL, `rate` varchar(255) NOT NULL, `strain_id` int(11) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB;");
        purge('<BR>activity_ratings table created');
    }
    if(!enum_tables("overall_activity_ratings")) {
        Query("CREATE TABLE `overall_activity_ratings` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `activity_id` INT NOT NULL , `rate` INT NOT NULL , `imported` TINYINT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        purge('<BR>overall_activity_ratings table created');
    }

    $types = query("SELECT * FROM strain_types", true);
    if(!enum_tables("ocs")){
        Query("CREATE TABLE `ocs` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `shorttext` TEXT NOT NULL , `price` INT NOT NULL, `category` VARCHAR(255) NOT NULL , `plant` VARCHAR(255) NOT NULL , `terpenes` VARCHAR(512) NOT NULL , `content` TEXT NOT NULL , `available` TINYINT NOT NULL , `ocs_id` INT NOT NULL, `prices` TEXT , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        purge('<BR>OCS table created');
    }
    if($forceupdate){
        purge('<BR>Full update requested. Deleting old and empty data');
        deleterow("ocs");
        deleterow("strains", 'name="" OR hasocs=2 OR slug LIKE "%-pre-roll" OR name LIKE "%Pre-Roll%" OR name LIKE "%(%THC%)" OR ((slug LIKE "%-1" OR name LIKE "%oil" OR name LIKE "%Capsules" OR name LIKE "%Softgels%") AND id > 3500)');
        Query("UPDATE strains SET hasocs = 0", false);
        Query("ALTER TABLE `ocs` DROP `prices`;");
        table_has_column("ocs", "prices", "TEXT");//$column, $type = false, $null = false, $default = false, $after = false, $isprimarykey = false, $comment
    }

    table_has_column("ocs", "slug", "VARCHAR(255)", false, false, "id");
    table_has_column("ocs", "lift_url", "TEXT");
    table_has_column("ocs", "lift_des", "TEXT");
    table_has_column("ocs", "lift_thc", "VARCHAR(16)");
    table_has_column("ocs", "lift_cbd", "VARCHAR(16)");
    table_has_column("ocs", "ocs_thc", "VARCHAR(16)");
    table_has_column("ocs", "ocs_cbd", "VARCHAR(16)");
    $allstrains = [];

    echo '</TD></TR><TR><TD>';
    //slug, vendor, status(importing, make new strains, skipped, failed), type, real name (without dash 1), our link, ocs link
    echo '<TABLE WIDTH="100%" BORDER="1" STYLE="border-collapse: collapse;"><THEAD><TR><TH>OCS Slug</TH><TH>Type</TH><TH>Progress</TH><TH>Vendor</TH><TH>Canbii Slug</TH><TH>Status</TH></TR></THEAD>';

    foreach($collections as $collection){
        $strains = enumstrains($collection);
        $allstrains = array_merge($strains);
        $data = json_encode($strains, JSON_PRETTY_PRINT);
        $filename = $dir . $collection . ".json";
        file_put_contents($filename, $data);
        $count = count($strains);
        foreach($strains as $INDEX => $strain){
            //echo '<BR><A HREF="' . $this->webroot . 'strains/' . $strain . '" TARGET="_new">' . $strain . '</A>';
            $URL = 'https://ocs.ca/products/' . $strain;
            echo '<TR><TD><A HREF="' . $URL . '">' . $strain . '</A></TD><TD>' . $collection . '</TD><TD>';
            $percent = round(($INDEX+1)/$count*100);
            echo '<DIV CLASS="parent"><DIV CLASS="progress" STYLE="width: ' . $percent . '%;"></DIV><DIV CLASS="indicator">' . ($INDEX+1) . '/' . $count . '=' . $percent . '%</DIV></DIV></TD>';
            $filename = $dir . $strain . ".json";
            $data = false;

            $DIDIT = false;
            $STATUS = ['SKIPPED'];
            if(!file_exists($filename) || $forceupdate) {
                $STATUS = ['DOWNLOADING HTML'];
                $data = extractdata($strain);
            } else if(file_exists($filename)) {
                $STATUS = ['LOADING JSON FILE'];
                $data = json_decode(file_get_contents($filename), true);
            }

            if($data) {
                $data = import($strain, $data, $me, $types, $collection, $options, $extradata, $negativeeffects, $dir);
                if(is_array($data)) {
                    $DIDIT = true;
                    echo '<TD>' . $data["vendor"] . '</TD><TD><A TARGET="_new" HREF="' . $this->webroot . 'strains/';
                    if (isset($data["mergedwith"])) {
                        $STATUS[] = "Merged";
                        echo $data["mergedwith"] . '">' . fromclassname($data["mergedwith"]) . '</A></TD>';
                    } else {
                        $STATUS[] = "Imported";
                        echo $strain . '">' . fromclassname($strain) . '</A></TD>';
                    }
                    if($data["downloadedimages"] > 0){
                        $STATUS[] = "Downloaded: " . $data["downloadedimages"] . " images";
                    }
                    if($data["skippedimages"] > 0){
                        $STATUS[] = "Skipped: " . $data["skippedimages"] . " images";
                    }
                    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
                } else if($data) {
                    $STATUS[] = $data;
                } else {
                    $STATUS[] = '***IMPORT FAILED (MISSING OR INVALID DATA)***';
                }
            } else {
                $STATUS[] = 'ERROR: DATA MISSING';
            }
            if(!$DIDIT){
                echo '<TD COLSPAN="2"></TD>';
            }
            purge('<TD>[' . implode("] [", $STATUS) . ']</TD></TR>');
        }
    }
    $data = json_encode($allstrains, JSON_PRETTY_PRINT);
    file_put_contents($dir . "allstrains.json", $data);
    die('</TABLE>Done!</TD></TR></TABLE>');
?>
