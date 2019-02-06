<?php
    header( 'Content-type: text/html; charset=utf-8' );
    @ini_set('zlib.output_compression',0);
    @ini_set('implicit_flush',1);
    @ob_end_clean();

    Configure::write('debug', 0);

    $options = [
        "makenewstrains" => false,//disable to prevent new strains from being created
    ];

    $negativeeffects = ["Bad Taste", "Cough", "Dry Mouth", "Harsh", "Headache", "Lazy", "Red Eyes", "Talkative", "Weak"];
    $extradata = [//CAUTION: lift_effects and lift_symptoms values are inverted (so truevalue=100-value)
        "ace-valley-cbd" => [
            "lift_url" => "https://lift.co/strains/ace-valley-ace-valley-cbd",
            "lift_vendor" => "Ace Valley",
            "lift_thc" => 6.5,
            "lift_cbd" => 12.7,
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_effects" => ["Calming" => 40, "Relaxed" => 45, "Happy" => 61.6667]
        ],
        "ace-valley-sativa" => [
            "lift_url" => "https://lift.co/strains/ace-valley-ace-valley-sativa",
            "lift_vendor" => "Ace Valley",
            "lift_thc" => 17.4,
            "lift_cbd" => 0,
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_effects" => ["Happy" => 66.6667]
        ],
        "airplane-mode" => [
            "lift_url" => "https://lift.co/strains/altavie-airplane-mode",
            "lift_vendor" => "Altavie",
            "lift_thc" => 16,
            "lift_cbd" => 0,
            "lift_des" => "A classic Kush that's earthy and woodsy on the nose, Airplane Mode is made up of compact, light green buds weaved with the occasional vibrant orange hair. Each dried flower is trimmed, sorted, and hang dried for a carefully crafted and hand-selected product.",
            "lift_flavors" => "",
            "lift_effects" => []
        ],
        "alien-dawg" => [
            "lift_url" => "https://lift.co/strains/aphria-inc-alien-dawg",
            "lift_vendor" => "Aphria Inc.",
            "lift_thc" => 24,
            "lift_cbd" => 0.1,
            "lift_des" => "",
            "lift_flavors" => "earthy, pungent, woody",
            "lift_effects" => ["Lazy" => 28.3333, "Red Eyes" => 36.6667, "Cough" => 45],
            "lift_symptoms" => ["Mood" => 30, "Appetite" => 41.6667, "Back Pain" => 41.6667, "Muscle Spasms" => 46.6667, "Headaches" => 48.3333]
        ],
        "argyle" => [
            "lift_url" => "https://lift.co/strains/tweed-argyle",
            "lift_vendor" => "Tweed",
            "lift_thc" => -1,
            "lift_cbd" => -1,
            "lift_des" => "Argyle is an indica-dominant strain with a balanced THC-to-CBD ratio. Its verdant green buds are quite dense and are accented by orange hairs. The terpene myrcene is responsible for Argyle's earthy aroma.",
            "lift_flavors" => "earthy, pine, sweet",
            "lift_effects" => ["Harsh" => 33.3333, "Weak" => 45, "Red Eyes" => 50, "Motivated" => 36.6667, "Sleepy" => 41.6667, "Giggly" => 45, "Anti-Anxiety" => 45, "Calming" => 46.6667]
        ],
        "bakerstreet" => [
            "lift_url" => "https://lift.co/strains/tweed-bakerstreet",
            "lift_vendor" => "Tweed",
            "lift_thc" => -1,
            "lift_cbd" => -1,
            "lift_des" => "The Bakerstreet cultivar is an indica-dominant THC strain. Its dense and deep green buds are highlighted with ochre-hued pistils and covered with trichomes. Terpinolene is the terpene which gives this strain its scent of juniper.",
            "lift_flavors" => "earthy, sweet, citrus",
            "lift_effects" => ["Talkative" => 40, "Lazy" => 43.3333, "Bad Taste" => 46.6667, "Motivated" => 15, "Calming" => 35, "Anxiety" => 36.6667, "Pain Relief" => 38.3333]
        ],
        "balance" => [
            "lift_url" => "https://lift.co/strains/solei-balance",
            "lift_vendor" => "Solei",
            "lift_thc" => 6.4,
            "lift_cbd" => 15.7,
            "lift_des" => "",
            "lift_flavors" => "earthy, citrus, musk",
            "lift_effects" => ["Bad Taste" => 75, "Dry Mouth" => 76.6667, "Headache" => 80, "Motivated" => 33.3333, "Social" => 36.6667, "Awake" => 53.3333, "Uplifted" => 53.3333, "Happy" => 53.3333]
        ],
        "balanced" => [
            "lift_url" => "https://lift.co/strains/plain-packaging-balanced",
            "lift_vendor" => "Plain Packaging",
            "lift_thc" => 13,
            "lift_cbd" => 13,
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_effects" => ["Relaxed" => 58.3333, "Calming" => 66.6667]
        ],
        "balanced-milled" => [
            "lift_url" => "https://lift.co/strains/plain-packaging-plain-packaging-balanced-milled",
            "lift_vendor" => "Plain Packaging",
            "lift_thc" => 13,
            "lift_cbd" => 13,
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
            "lift_goodeffects" => ["calming" => "43.3333", "relaxed" => "46.6667", "sleepy" => "50"]
        ],
        "banana-split" => [
            "lift_url" => "https://lift.co/strains/aurora-recreational-banana-split",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "20",
            "lift_cbd" => "1",
            "lift_des" => "A rare, balanced hybrid strain with dense colas that house sweet, floral aromas. Aurora’s Banana Split is made up of large, dark green buds with vibrant orange pistil hairs and a thick coating of trichomes.",
            "lift_flavors" => "banana, sweet, fruit",
            "lift_badeffects" => ["dry mouth" => "56.6667"],
            "lift_goodeffects" => ["uplifted" => "45", "happy" => "48.3333", "relaxed" => "50", "calming" => "53.3333", "energetic" => "58.3333"]
        ],
        "bc-delahaze" => [
            "lift_url" => "https://lift.co/strains/flowr-bc-delahaze",
            "lift_vendor" => "Flowr",
            "lift_thc" => "28",
            "lift_cbd" => "0",
            "lift_des" => "Delahaze is an award-winning cultivar known for its powerful, invigorating effects. Flowr’s BC Delahaze is expertly grown in our indoor facility to emphasize its potency and flavour, with citrus and mango notes. Carefully harvested, hand-trimmed and craft-cured, our BC Delahaze is sure to become one of your favourites.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
	        "lift_goodeffects" => ["energetic" => "66.6667", "awake" => "78.3333"]
        ],
        "bc-pink-kush" => [
            "lift_url" => "https://lift.co/strains/flowr-bc-pink-kush",
            "lift_vendor" => "Flowr",
            "lift_thc" => "28",
            "lift_cbd" => "0",
            "lift_des" => "With origins in the Hindu Kush mountain range, Flowr’s Pink Kush is sweet-smelling product that is craft grown in BC and hand-trimmed to emphasize its pink hairs, bright green flower, and sugar-like trichomes.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "bc-sensi-star" => [
            "lift_url" => "https://lift.co/strains/flowr-bc-sensi-star",
            "lift_vendor" => "Flowr",
            "lift_thc" => "17",
            "lift_cbd" => "0",
            "lift_des" => "Flowr’s BC Sensi Star is a legendary indica renowned for its dark Green and Purple colouration with sparkling crystal trichomes. This exceptional product is expertly grown in our indoor facility in Kelowna to emphasize its potency and flavour, which consists of earthy undertones with a hint of berry. Hand-trimmed and craft cured, Sensi Star is a must for everyone’s core product set.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "blue-dream" => [
            "lift_url" => "https://lift.co/strains/aurora-recreational-blue-dream",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "22",
            "lift_cbd" => "0",
            "lift_des" => "A classic sativa-dominant hybrid strain, with dense light green buds. This high THC strain has a sweet berry, and pine aroma.",
            "lift_flavors" => "sweet, berry, earthy",
            "lift_badeffects" => ["cough" => "36.6667", "bad taste" => "66.6667", "dry eyes" => "66.6667"],
            "lift_goodeffects" => ["relaxed" => "25", "happy" => "28.3333", "uplifted" => "31.6667", "euphoric" => "46.6667", "social" => "50"]
        ],
        "blueberry-kush" => [
            "lift_url" => "https://lift.co/strains/synrg-blueberry-kush",
            "lift_vendor" => "Synr.g",
            "lift_thc" => "23",
            "lift_cbd" => "1",
            "lift_des" => "Freshly baked blueberry pie, anyone? This hybrid’s fragrant lip-smacking berry flavour is complemented by a crisp citrus note. Dark blue and purple tones are topped by exquisite crystal bouquets of light green and golden hairs.",
            "lift_flavors" => "blueberry, berry, fruity",
            "lift_badeffects" => ["dry mouth" => "45"],
            "lift_goodeffects" => ["relaxed" => "33.3333", "sleepy" => "38.3333", "happy" => "58.3333", "euphoric" => "61.6667", "calming" => "61.6667"]
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
            "lift_symptoms" => ["insomnia" => "33.3333", "stress" => "36.6667", "depression" => "38.3333", "anxiety" => "46.6667"]
        ],
        "cabaret" => [
            "lift_url" => "https://lift.co/strains/altavie-cabaret",
            "lift_vendor" => "Altavie",
            "lift_thc" => "20.3",
            "lift_cbd" => "0",
            "lift_des" => "Cabaret is a sativa-dominant strain that offers a sweet and floral aroma with hints of grapefruit. It is made up of loose and sticky buds that are cone shaped, similar to arrowheads. In terms of colour, Cabaret is light green and accented by thick, bright orange hairs.",
            "lift_flavors" => "herbal, earthy, floral",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["euphoric" => "26.6667", "energetic" => "28.3333", "relaxed" => "45", "focused" => "56.6667"]
        ],
        "campfire" => [
            "lift_url" => "https://lift.co/strains/altavie-campfire",
            "lift_vendor" => "Altavie",
            "lift_thc" => "4.6",
            "lift_cbd" => "7.3",
            "lift_des" => "Campfire is a mild THC, high-CBD strain with rich, floral notes. Physically, expect somewhat dense, light green buds with hues of yellow and lots of orange hairs.",
            "lift_flavors" => "earthy, herbal, floral",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "46.6667", "calming" => "51.6667", "sleepy" => "53.3333", "uplifted" => "53.3333", "euphoric" => "70"]
        ],
        "casablanca" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-casablanca",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "citrus",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "41.6667", "calming" => "45", "happy" => "46.6667", "sleepy" => "56.6667", "appetite enhancing" => "60"]
        ],
        "cbd-shark-shock-redecan" => [
            "lift_url" => "https://lift.co/strains/redecan-cbd-shark-shock",
            "lift_vendor" => "Redecan",
            "lift_thc" => "7",
            "lift_cbd" => "12",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => ["dry mouth" => "86.6667"],
            "lift_goodeffects" => ["calming" => "53.3333"]
        ],
        "chocolate-fondue" => [
            "lift_url" => "https://lift.co/strains/dna-genetics-chocolate-fondue",
            "lift_vendor" => "DNA Genetics",
            "lift_thc" => "0",
            "lift_cbd" => "0",
            "lift_des" => "This sativa-dominant THC strain is a well-balanced cross of Exodus UK Cheese and Chocolope. Chocolate Fondue has a complex aroma that is funky, robust and sweet like chocolate. Bred by DNA Genetics.",
            "lift_flavors" => "sweet, cheese, earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["uplifted" => "33.3333", "focused" => "36.6667", "energetic" => "43.3333", "social" => "45", "calming" => "48.3333"]
        ],
        "city-lights" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-city-lights",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "48.3333", "calming" => "51.6667", "happy" => "58.3333", "euphoric" => "78.3333"]
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
            "lift_symptoms" => ["inflammation" => "11.6667", "anxiety" => "28.3333", "back pain" => "30", "insomnia" => "38.3333"]
        ],
        "critical-super-silver-haze" => [
            "lift_url" => "https://lift.co/strains/canna-farms-critical-super-silver-haze",
            "lift_vendor" => "Canna Farms",
            "lift_thc" => "16.8",
            "lift_cbd" => "0.1",
            "lift_des" => "A colourful plant, Critical Super Silver Haze is known for it's slightly citrusy aromas with incense and mentholated wood notes with hints of haze and even pungent varnish. Flowers are dense, coated with trichomes, and contain hints of purple colour throughout.",
            "lift_flavors" => "citrus, earthy, citrusy",
            "lift_badeffects" => ["lazy" => "50", "hungry" => "50", "weak" => "53.3333"],
            "lift_goodeffects" => ["tasteful" => "23.3333", "happy" => "31.6667", "uplifted" => "35", "energetic" => "35", "alert" => "36.6667"]
        ],
        "delahaze" => [
            "lift_url" => "https://lift.co/strains/san-rafael-71-delahaze",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => 25,
            "lift_cbd" => 0,
            "lift_des" => "Delahaze is a sativa strain posessing mango notes and sticky, cone-like buds. It is light green in colour with thin orange hairs running throughout.",
            "lift_flavors" => "citrus, lemon, sweet",
            "lift_effects" => ["Dry Mouth" => 73.3333, "Happy" => 31.6667, "Euphoric" => 36.6667, "Uplifted" => 50, "Energetic" => 50, "Awake" => 51.6667]
        ],
        "easy-cheesy" => [
            "lift_url" => "https://lift.co/strains/liiv-easy-cheesy",
            "lift_vendor" => "liiv",
            "lift_thc" => "20",
            "lift_cbd" => "1",
            "lift_des" => "This sativa-dominant descendent of Original Cheese has sharp, rich, sour notes, giving it its cheesy name. The dark green buds, accented by bright copper hairs, produce an extra old cheddar aroma, and a ?oral, pine aftertaste.",
            "lift_flavors" => "cheese",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "fantasy-island" => [
            "lift_url" => "https://lift.co/strains/synrg-fantasy-island",
            "lift_vendor" => "Synr.g",
            "lift_thc" => "15",
            "lift_cbd" => "1",
            "lift_des" => "This indica-dominant hybrid features bright amber hairs exploding through a thick green canopy. The medium sized buds are compact with a wool-like structure; taste buds tingle from the luxurious tang of rich berry, sweet pine, and hints of pumpkin spice.",
            "lift_flavors" => "fruity, berry, citrus",
            "lift_badeffects" => ["dry mouth" => "76.6667"],
            "lift_goodeffects" => ["relaxed" => "35", "happy" => "40", "calming" => "45", "euphoric" => "51.6667", "sleepy" => "53.3333"]
        ],
        "fleur-de-lune-intimate" => [
            "lift_url" => "https://lift.co/oils/hydropothecary-fleur-de-lune-intimate-spray",
            "lift_vendor" => "Hydropothecary",
            "lift_thc" => "10 mg/ml",//WARNING
            "lift_cbd" => "1 mg/ml",//WARNING
            "lift_des" => "Easy to use and convenient, Fleur de Lune is a THC intimate oil containing up to 600mg of THC. One 60ml bottle offers up to 460 sprays. Equivalency factor for purchasing calculations 60 ml bottle = 6 g dried cannabis(10 ml cannabis oil = 1 g dried cannabis)",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "galiano" => [
            "lift_url" => "https://lift.co/strains/broken-coast-cannabis-galiano",
            "lift_vendor" => "Broken Coast Cannabis",
            "lift_thc" => "19.6",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy, herbal",
            "lift_badeffects" => ["hungry" => "70", "dry mouth" => "95"],
            "lift_goodeffects" => ["uplifted" => "21.6667", "happy" => "41.6667", "appetite enhancing" => "45", "awake" => "48.3333", "creative" => "48.3333"]
        ],
        "gather" => [
            "lift_url" => "https://lift.co/strains/solei-gather-strain",
            "lift_vendor" => "Solei",
            "lift_thc" => "24.7",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["awake" => "46.6667", "happy" => "50", "energetic" => "58.3333"]
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
        "ghost-train-haze" => [[
            "lift_url" => "https://lift.co/strains/weedmd-ghost-train-haze",
            "lift_vendor" => "WeedMD",
            "lift_thc" => "26",
            "lift_cbd" => "0.1",
            "lift_des" => "Ghost Train Haze is a sativa dominant strain with typical sativa stretching. The dense inflorescences (buds) are a lighter green with orange/golden complimentary tones. The lineage of Ghost Train Haze is Ghost OG x Neviles Wreck. Ghost OG is an indica dominant strain and Neviles Wreck is a sativa dominant strain. Ghost Train Haze has notes of floral, citrus and hints of spice.",
            "lift_flavors" => "earthy, citrus, pungent",
            "lift_badeffects" => ["coughing" => "53.3333", "dry eyes" => "60", "dry mouth" => "68.3333"],
            "lift_goodeffects" => ["social" => "25", "happy" => "36.6667", "motivated" => "40", "euphoric" => "40", "tasteful" => "41.6667"]
        ],[
            "lift_url" => "https://lift.co/strains/aurora-recreational-ghost-train-haze",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "22",
            "lift_cbd" => "1",
            "lift_des" => "A high THC sativa strain with a sweet and piney aroma with hints of citrus, lemon, and spice. Aurora's Ghost Train Haze is made up of large, dark green buds beautifully entwined with bright orange pistil hairs.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => ["dry mouth" => "50"],
            "lift_goodeffects" => ["uplifted" => "36.6667", "awake" => "66.6667", "happy" => "66.6667"]
        ],[
            "lift_url" => "https://lift.co/strains/redecan-pharm-ghost-train-haze",
            "lift_vendor" => "RedeCan Pharm",
            "lift_thc" => "24.8",
            "lift_cbd" => "10.7",
            "lift_des" => "Sativa Dominant80% Sativa/ 20% IndicaCross between: Ghost OG and Neville’s Wreck",
            "lift_flavors" => "woody, citrus",
            "lift_badeffects" => ["dry eyes" => "60"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["anxiety" => "30", "back pain" => "36.6667"]
        ]],
        "god-bud" => [
            "lift_url" => "https://lift.co/strains/redecan-god-bud",
            "lift_vendor" => "RedeCan Pharm",
            "lift_thc" => "19",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "citrus, berry",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "33.3333", "euphoric" => "41.6667", "sleepy" => "48.3333", "calming" => "58.3333"]
        ],
        "great-white-shark" => [
            "lift_url" => "https://lift.co/strains/san-rafael-71-great-white-shark",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => "7.3",
            "lift_cbd" => "13.9",
            "lift_des" => "Great White Shark is a carefully cultivated 2:1 sativa strain that offers the benefits of both CBD and THC. Enhanced by a unique and earthy aroma, this strain is very sticky and resinous to the touch, with light green leaves and dark, thick orange hairs.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "33.3333", "focused" => "36.6667", "relaxed" => "43.3333"]
        ],
        "gsc" => [
            "lift_url" => "https://lift.co/strains/canna-farms-gsc",
            "lift_vendor" => "Canna Farms",
            "lift_thc" => "22",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => ["dry mouth" => "78.3333"],
            "lift_goodeffects" => ["happy" => "16.6667", "relaxed" => "33.3333", "calming" => "36.6667"]
        ],
        "harmonic" => [
            "lift_url" => "https://lift.co/strains/altavie-harmonic",
            "lift_vendor" => "Altavie",
            "lift_thc" => "10.6",
            "lift_cbd" => "10.1",
            "lift_des" => "Harmonic is a balanced strain that maximizes on both cannabinoids by having equal parts CBD and THC. With fairly loose and airy flowers, the buds of this unique strain range from long and thin to spherical in shape. This product is made up of dark green buds interlaced with dark orange hairs, and is available as dried flowers and soft-gels.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "56.6667", "relaxed" => "66.6667"]
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
            "lift_goodeffects" => ["motivated" => "36.6667", "awake" => "36.6667", "focused" => "38.3333", "calming" => "40"]
        ],
        "kinky-kush" => [
            "lift_url" => "https://lift.co/strains/liiv-kinky-kush",
            "lift_vendor" => "liiv",
            "lift_thc" => "27",
            "lift_cbd" => "1",
            "lift_des" => "Descending from award-winning Californian genetics, this indica showcases a dusting of trichomes that crown the dense forest of green. A smoky, woody, pine aroma highlighted by hints of lilac greets the nostrils.THC: 27%CBD: ?1% Dried Flower: 1 g, 3.5 g, 7 g Pre-Rolled Joints: 1x1 g, 2x0.5 g, 5x0.5 g",
            "lift_flavors" => "earthy, kush, pine",
            "lift_badeffects" => ["sleepy" => "71.6667", "dry mouth" => "75", "cough" => "78.3333"],
            "lift_goodeffects" => ["sleepy" => "38.3333", "relaxed" => "38.3333", "appetite enhancing" => "43.3333", "calming" => "48.3333", "happy" => "50"]
        ],
        "la-strada" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-la-strada",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0.2",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["awake" => "58.3333"]
        ],
        "lemon-skunk" => [
            "lift_url" => "https://lift.co/strains/dna-genetics-lemon-skunk",
            "lift_vendor" => "DNA Genetics",
            "lift_thc" => "25 mg/ml",
            "lift_cbd" => "0.7 mg/ml",
            "lift_des" => "12-22% THC | <0.07% CBD\nLemon Skunk is a cross between two Skunk strains, the chosen phenotype selected for its lemon characteristics. Lemon Skunk brings together the scent of lemons, black pepper and hints of citrus. Its buds are light green with thick orange hairs and a high calyx to leaf ratio. Lemon Skunk has a mid-range THC content. Bred by DNA Genetics. ",
            "lift_flavors" => "lemon, citrus, earthy",
            "lift_badeffects" => ["weak" => "45", "dry eyes" => "58.3333", "dry mouth" => "61.6667"],
            "lift_goodeffects" => ["tasteful" => "25", "uplifted" => "36.6667", "creative" => "40", "euphoric" => "40", "focused" => "41.6667"]
        ],
        "lola-montes" => [
            "lift_url" => "https://lift.co/strains/edison-cannabis-co-lola-montes",
            "lift_vendor" => "Edison Cannabis Co.",
            "lift_thc" => "20",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["sleepy" => "25", "relaxed" => "36.6667", "calming" => "46.6667"]
        ],
        "lola-montes-reserve" => [
            "lift_url" => "https://lift.co/strains/edison-reserve-lola-montes-reserve",
            "lift_vendor" => "Edison Reserve",
            "lift_thc" => "22",
            "lift_cbd" => "0",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "mango-haze" => [[
            "lift_url" => "https://lift.co/strains/weedmd-mango-haze",
            "lift_vendor" => "WeedMD",
            "lift_thc" => "9",
            "lift_cbd" => "14.7",
            "lift_des" => "Mango Haze is a mostly Sativa strain, who crossed Northern Lights #5, Skunk, and Haze to create this uplifting, fruity variety. Mango Haze exhibits a distinctive mango aroma coupled with spicy, sour undertones. The inflorescences (buds) are dark green, resinous and dense with bright orange pistils.",
            "lift_flavors" => "mango, fruity, citrus",
            "lift_badeffects" => ["dry eyes" => "63.3333", "dry mouth" => "68.3333"]
            ,"lift_goodeffects" => [],
            "lift_symptoms" => ["stress" => "18.3333", "fatigue" => "28.3333", "mood" => "31.6667", "pain" => "36.6667", "headaches" => "38.3333"]
        ], [
            "lift_url" => "https://lift.co/strains/kiwi-cannabis-mango-haze",
            "lift_vendor" => "Kiwi Cannabis",
            "lift_thc" => "10",
            "lift_cbd" => "5",
            "lift_des" => "",
            "lift_flavors" => "citrus, mango, earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "50", "focused" => "53.3333", "relaxed" => "56.6667", "euphoric" => "60", "awake" => "63.3333"]
        ]],
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
            "lift_goodeffects" => ["relaxed" => "25", "calming" => "41.6667"]
        ],
        "north-star-cbd" => [
            "lift_url" => "https://lift.co/strains/altavie-north-star-cbd",
            "lift_vendor" => "Altavie",
            "lift_thc" => "0.7",
            "lift_cbd" => "16",
            "lift_des" => "A rare strain with bold floral scents, North Star is ideal for those seeking the benefits of CBD. It's made up of sticky, dense, medium-sized buds that are dark green in colour with hues of light purple. North Star comes in dried flower and soft-gel form to meet the needs of all our clients.",
            "lift_flavors" => "earthy, flowery",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "28.3333", "happy" => "41.6667", "focused" => "43.3333", "calming" => "43.3333", "uplifted" => "61.6667"]
        ],
        "northern-lights-moc" => [
            "lift_url" => "https://lift.co/strains/united-greeneries-northern-lights-moc",
            "lift_vendor" => "United Greeneries",
            "lift_thc" => "12.4",
            "lift_cbd" => "0",
            "lift_des" => "Northern Lights MOC is a classic strain that was concocted near the end of the 80s. This is a quality indica composed of 100% Northern Lights genetics. Proudly cultivated on Vancouver Island in British Columbia. Dominant Terpene Profile: Myrcene (terpenic, rose, herbal) Alpha Pinene (fresh, sweet, earthy)",
            "lift_flavors" => "smooth, lemon, sweet",
            "lift_badeffects" => ["red eyes" => "78.3333"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["stress" => "6.66667", "anxiety" => "13.3333", "pain" => "30"]
        ],
        "palm-tree" => [
            "lift_url" => "https://lift.co/strains/lbs-palm-trees-cbd-indica",
            "lift_vendor" => "LBS",
            "lift_thc" => "17",
            "lift_cbd" => "12",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
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
            "lift_symptoms" => ["appetite" => "35", "insomnia" => "35", "mood" => "38.3333", "muscle pain" => "40", "nausea" => "40"]
        ],
        "purple-chitral" => [
            "lift_url" => "https://lift.co/strains/san-rafael-71-purple-chitral",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => "21",
            "lift_cbd" => "0",
            "lift_des" => "This mid-potency indica strain features a unique cheese aroma with hints of berry. Its buds are dark purple and dense, with little to no orange hairs. This strain is made up of large calyxes that appear like concord grapes, creating buds that are dense and cone-shaped.",
            "lift_flavors" => "berry, floral, earthy",
            "lift_badeffects" => ["hungry" => "78.3333"],
            "lift_goodeffects" => ["relaxed" => "35", "giggly" => "45", "happy" => "53.3333", "calming" => "55", "sleepy" => "56.6667"]
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
            "lift_goodeffects" => ["motivated" => "41.6667", "calming" => "66.6667"]
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
            "lift_goodeffects" => ["creative" => "50", "energetic" => "51.6667", "awake" => "51.6667", "happy" => "53.3333", "relaxed" => "56.6667"]
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
            "lift_des" => "San Fernando Valley is a sativa dominant hybrid that is related to OG Kush. This strain is the precursor to the indica dominant SFV OG. The aroma is sweet and mingles with hints of mellow citrus and berries, an interesting terpene profile. The inflorescences of WeedMD’s San Fernando Valley are dense with a spectrum of purple hues.",
            "lift_flavors" => "berry, citrusy, earthy",
            "lift_badeffects" => ["dry mouth" => "58.3333", "hungry" => "61.6667"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["depression" => "16.6667", "stress" => "28.3333", "mood" => "33.3333", "pain" => "38.3333", "lack of appetite" => "40"]
        ],
        "saturday-night" => [
            "lift_url" => "https://lift.co/strains/saturday-saturday-night-pre-roll",
            "lift_vendor" => "Saturday",
            "lift_thc" => "14",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "serious-kush" => [
            "lift_url" => "https://lift.co/strains/royal-high-serious-kush",
            "lift_vendor" => "Royal High",
            "lift_thc" => "18.3",
            "lift_cbd" => "0.1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "shishkaberry" => [[
            "lift_url" => "https://lift.co/strains/redecan-shishkaberry",
            "lift_vendor" => "Redecan",
            "lift_thc" => "16",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "berry",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["calming" => "53.3333", "sleepy" => "66.6667", "relaxed" => "70"]
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
            "lift_des" => "Shishkaberry, is an indica-dominant hybrid that came about from crossing DJ Short Blueberry with an unknown Afghani strain. Shishkaberry’s buds have a fruit and berry aroma and will be painted with shades of purple.",
            "lift_flavors" => "berry, fruity, blueberry",
            "lift_badeffects" => ["dry mouth" => "71.6667", "coughing" => "95"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["depression" => "6.66667", "stress" => "11.6667", "insomnia" => "21.6667", "anxiety" => "25", "pain" => "30"]
        ]],
        "solar-power" => [
            "lift_url" => "https://lift.co/strains/symbl-solar-power",
            "lift_vendor" => "Symbl",
            "lift_thc" => "21",
            "lift_cbd" => "0",
            "lift_des" => "AKA Sour Kush, this Symbl hybrid has a tightly packed bud structure with dense, vibrant green flowers covered with amber pistils and sprinkled with frosty trichomes. Terrifically tart and superbly pungent, Sour Kush is known for its powerful flavour profile combining sour, crisp lemon and invigorating pine. The robust, tangy citrus taste is balanced with hints of earthy wood and sharp diesel.",
            "lift_flavors" => "earthy, citrus, pine",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["happy" => "28.3333", "energetic" => "46.6667", "giggly" => "53.3333", "relaxed" => "53.3333", "awake" => "61.6667"]
        ],
        "sunset" => [
            "lift_url" => "https://lift.co/strains/lbs-sunset",
            "lift_vendor" => "LBS",
            "lift_thc" => "17",
            "lift_cbd" => "12",
            "lift_des" => "",
            "lift_flavors" => "earthy, flowery, sweet",
            "lift_badeffects" => ["bad taste" => "58.3333", "lazy" => "61.6667", "hungry" => "75"],
            "lift_goodeffects" => ["euphoric" => "28.3333", "sleepy" => "43.3333", "calming" => "45", "relaxed" => "45", "happy" => "61.6667"]
        ],
        "super-skunk" => [
            "lift_url" => "https://lift.co/strains/united-greeneries-super-skunk",
            "lift_vendor" => "United Greeneries",
            "lift_thc" => "16.1",
            "lift_cbd" => "0",
            "lift_des" => "This indica dominant hybrid is derived from Skunk #1 and Afghani genetics. Proudly cultivated on Vancouver Island in British Columbia.PercentagesTHC: 16.1%CBD: 0.00%Dominant Terpene ProfileCaryophyllene (spicy, black pepper)Myrcene (herbal, woody)Alpha Pinene (fresh, piney, sweet) ",
            "lift_flavors" => "skunk, spicy/herbal, skunky",
            "lift_badeffects" => ["hungry" => "20", "red eyes" => "65"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["stress" => "20", "headaches" => "28.3333", "anxiety" => "30", "back pain" => "36.6667", "pain" => "38.3333"]
        ],
        "super-sonic" => [
            "lift_url" => "https://lift.co/strains/symbl-super-sonic",
            "lift_vendor" => "Symbl",
            "lift_thc" => "17",
            "lift_cbd" => "0",
            "lift_des" => "AKA Quantum Kush, it’s a tall-growing sativa that has fairly dense, olive green buds speckled with a flecks of rusty red and a lush coating of frosty trichomes. Don’t be misguided by the common name; unlike most Kush strains, this one is most definitely sativa-dominant. Super Sonic has a classic, yet complex earthy, sweet aroma that’s pleasantly pungent, coupled with a sumptuous tropical taste.",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "tangerine-dream" => [[
            "lift_url" => "https://lift.co/strains/canna-farms-tangerine-dream",
            "lift_vendor" => "Canna Farms",
            "lift_thc" => "17.6",
            "lift_cbd" => "0.1",
            "lift_des" => "The Tangerine Dream is a true delight.  A combination of G13, Afghani and Neville's Haze brings you a Sativa dominant strain that energizes you while working to knock out pain and relax muscles. Combat your stress and anxiety and uplifted throughout your day.. One taste of the Tangerine will feel like a Dream!",
            "lift_flavors" => "citrus, orange, fruity",
            "lift_badeffects" => ["nothing" => "45", "giggly" => "48.3333"],
            "lift_goodeffects" => ["tasteful" => "18.3333", "anxiety" => "30", "giggly" => "43.3333", "calming" => "43.3333", "social" => "45"]
        ],[
            "lift_url" => "https://lift.co/strains/san-rafael-71-tangerine-dream",
            "lift_vendor" => "San Rafael 71",
            "lift_thc" => "16.2",
            "lift_cbd" => "0",
            "lift_des" => "Tangerine Dream is a high THC sativa strain highlighted by a citrus aroma along with an unmistakable, purple hue. This dried flower is made up of purple and green buds that are fairly dense, but break up easily when handled. \n",
            "lift_flavors" => "citrus, orange, citrusy",
            "lift_badeffects" => ["forgetful" => "61.6667", "dry eyes" => "71.6667", "coughing" => "75"],
            "lift_goodeffects" => ["tasteful" => "21.6667", "happy" => "38.3333", "giggly" => "45", "focused" => "46.6667", "uplifted" => "46.6667"]
        ],[
            "lift_url" => "https://lift.co/strains/whistler-medical-marijuana-tangerine-dream",
            "lift_vendor" => "Whistler Medical Marijuana",
            "lift_thc" => "19.6",
            "lift_cbd" => "0.1",
            "lift_des" => "This winner of the 2010 Cannabis Cup was created by the illustrious Barney’s Farm. A strain for connoisseurs, Tangerine Dream is the hybrid daughter of G13 and Neville’s breeder strain A5. Its ability to knock out pain while increasing energy is what makes Tangerine Dream so special. While too much Tangerine Dream may leave you stuck on the couch, this strain was handcrafted to meet the demands of working medical patients. Uplifting and euphoric, it provides users with mental clarity while deeply relaxing muscles. Tangerine Dream typically flowers in 8 to 10 weeks and features a citrusy aroma.",
            "lift_flavors" => "citrus, orange, sweet",
            "lift_badeffects" => ["dry mouth" => "56.6667"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["depression" => "36.6667", "insomnia" => "46.6667", "anxiety" => "55", "pain" => "55", "stress" => "60"]
        ]],
        "temple" => [
            "lift_url" => "https://lift.co/strains/aurora-recreational-temple",
            "lift_vendor" => "Aurora - Recreational",
            "lift_thc" => "1",
            "lift_cbd" => "14",
            "lift_des" => "A high CBD, low-THC, hybrid strain with an earthy, pine aroma with undertones of crushed grape. Aurora’s Temple is made up of smaller, dark green buds with hints of purple and navy, accented by orange pistil hairs.",
            "lift_flavors" => "earthy, sweet",
            "lift_badeffects" => ["bad taste" => "80"],
            "lift_goodeffects" => ["calming" => "58.3333", "relaxed" => "60", "awake" => "75"]
        ],
        "ultra-sour" => [[
            "lift_url" => "https://lift.co/strains/zenabis-ultra-sour",
            "lift_vendor" => "Zenabis",
            "lift_thc" => "22.3",
            "lift_cbd" => "0.1",
            "lift_des" => "",
            "lift_flavors" => "sour, citrusy, diesel",
            "lift_badeffects" => ["cough" => "86.6667"],
            "lift_goodeffects" => [],
            "lift_symptoms" => ["depression" => "28.3333", "anxiety" => "46.6667"]
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
        ]],
        "unplug" => [
            "lift_url" => "https://lift.co/strains/solei-unplug",
            "lift_vendor" => "Solei",
            "lift_thc" => "24.7",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "",
            "lift_badeffects" => [],
            "lift_goodeffects" => []
        ],
        "wappa" => [[
            "lift_url" => "https://lift.co/strains/redecan-wappa",
            "lift_vendor" => "Redecan",
            "lift_thc" => "20",
            "lift_cbd" => "1",
            "lift_des" => "",
            "lift_flavors" => "earthy, fruity",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "26.6667", "happy" => "33.3333", "calming" => "35", "sleepy" => "53.3333"]
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
        ]],
        "white-shark" => [[
            "lift_url" => "https://lift.co/strains/weedmd-white-shark",
            "lift_vendor" => "WeedMD",
            "lift_thc" => "16.1",
            "lift_cbd" => "0",
            "lift_des" => "White Shark is a Sativa dominant strain which has won the High Times Cannabis Cup in 1997 for best Hybrid. White Shark is a cross between Super Skunk x Brazilian x South Indian. Super Skunk is an Indica dominant strain while Brazilian and South Indian are Sativa dominant. White Shark shows characteristics from both a Sativa and an Indica. The inflorescences (buds) are dense, light green and express subtle golden hues. The aroma consists of notes of pine, lemon and complimentary grape undertones. ",
            "lift_flavors" => "dank, earthy, lemon",
            "lift_badeffects" => ["hungry" => "46.6667",
                "dry eyes" => "61.6667",
                "dry mouth" => "65"],"lift_goodeffects" => ["relaxed" => "15",
                "uplifted" => "16.6667",
                "sleepy" => "20",
                "euphoric" => "30",
                "energetic" => "31.6667"]
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
        ],],
        "white-widow" => [[
            "lift_url" => "https://lift.co/strains/canaca-white-widow",
            "lift_vendor" => "Canaca",
            "lift_thc" => "1.1 mg/ml",
            "lift_cbd" => "0 mg/ml",
            "lift_des" => "",
            "lift_flavors" => "mild",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["relaxed" => "50"]
        ],[
            "lift_url" => "https://lift.co/strains/7acres-white-widow",
            "lift_vendor" => "7Acres",
            "lift_thc" => "20",
            "lift_cbd" => "1",
            "lift_des" => "White Widow has earned its place as a multiple award-winning Cultivar with widespread consumer appeal. Since its birth in 1994, White Widow has been known for being highly resinous, it’s name was made in reference to the visually prominent white coating of trichomes the strain produces.White Widow is a highly resinous, balanced hybrid with a pungent, sweet and woody aroma.",
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
        ]],
        "yin-yang" => [
            "lift_url" => "https://lift.co/strains/liiv-yin-yang",
            "lift_vendor" => "liiv",
            "lift_thc" => "10",
            "lift_cbd" => "13",
            "lift_des" => "This indica-dominant hybrid is beautifully balanced. Descending from the famous Harlequin and Jack the Ripper strains, its purple-fringed buds feature orange touches, with pink and yellow undertones. The pungent, woody aroma, dotted with notes of sweet herbs, coffee and black pepper, builds on a delicious pine foundation.",
            "lift_flavors" => "earthy",
            "lift_badeffects" => [],
            "lift_goodeffects" => ["happy" => "38.3333", "calming" => "56.6667", "relaxed" => "61.6667", "focused" => "66.6667"]
        ]
    ];
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

    function file_get_cookie_contents_ocs($method = "GET", $URL, $querydata = false, $POSTdata = false, $Cookie = false){
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
            return gzdecode(file_get_contents($URL, false, $context));
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

    function trimend($Text, $Trim){
        if( endswith(strtolower($Text), strtolower($Trim)) ){
            $Text = left($Text, strlen($Text) - strlen($Trim));
        }
        return trim($Text);
    }

    function cleanslug($slug = "lemon-skunk-capsules-2-5mg"){
        if(!is_array($slug)){$slug = explode("-", $slug);}
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
        $wordstoremove = ["oil", "oral", "spray", "mct", "thc", "peppermint", "capsules", "pre", "roll", "pack"];
        $last = count($slug) - 1;
        foreach(array_reverse($slug) as $index => $word){
            $index = $last - $index;
            if(in_array( $word, $wordstoremove )){
                unset( $slug[$index] );
            } else {
                break;
            }
        }
        return implode("-", $slug);
    }

    function fromclassname($slug){
        $slug = explode("-", $slug);
        foreach($slug as $KEY => $VALUE){
            $slug[$KEY] = ucfirst($VALUE);
        }
        return trim(implode(" ", $slug));
    }

    function import($strain, $JSONdata, $me, $types, $collection, $options) {
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
                        $data = first("SELECT * FROM effects WHERE title='" . $tag . "'");
                        if (!$data) {
                            $data = ["title" => $tag, "imported" => 1, "negative" => 0];
                            $data["id"] = insertdb('effects', $data);
                        }
                        $tags[$tag] = $data;
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
                        "hasocs" => 1,
                        "type_id" => getiterator($types, "title", $plant)["id"],
                        "name" => trimend($JSONdata["title"], "pre-roll"),
                        "description2" => $JSONdata["content"],
                        "slug" => $strain,
                        "imported" => "2"//0=native, 1=leafly, 2=ocs
                    ];
                    if ($localstrain["name"] && $localstrain["description2"]) {
                        $localstrain["id"] = insertdb("strains", $localstrain);
                    }
                } else {
                    return "Skipped, makenewstrains=false";
                }
            } else {
                return false;
            }

            if (isset($localstrain["id"]) && $localstrain["id"]) {
                $ocsdata = first("SELECT * FROM ocs WHERE strain_id=" . $localstrain["id"]);
                if (!$ocsdata && isset($JSONdata["content"])) {//add to ocs table
                    if (!isset($JSONdata["Terpenes"]) || !is_array($JSONdata["Terpenes"])) {
                        $JSONdata["Terpenes"] = [];
                    }
                    $ocsdata = [
                        "category" => $JSONdata["type"],
                        "strain_id" => $localstrain["id"],
                        "shorttext" => $JSONdata["shorttext"],
                        "price" => $JSONdata["price"],
                        "plant" => $JSONdata["Plant"],
                        "terpenes" => implode(", ", $JSONdata["Terpenes"]),
                        "content" => $JSONdata["content"],
                        "available" => $JSONdata["available"] == "true",
                        "ocs_id" => $JSONdata["id"]
                    ];
                }

                $prices = [];
                if ($mergeprices && isset($ocsdata["prices"]) && $ocsdata["prices"]) {
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
    echo '<BR>Downloading all: ' . implode(", ", $collections);
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
        echo '<BR>activities table created and filled with (' . implode(", ", $activities) . ")";
    }
    if(!enum_tables("activity_ratings")) {
        Query("CREATE TABLE `activity_ratings` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL, `review_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL, `rate` varchar(255) NOT NULL, `strain_id` int(11) NOT NULL, `imported` tinyint(4) NOT NULL COMMENT '(Imported from Leafly)', PRIMARY KEY (`id`)) ENGINE=InnoDB;");
        echo '<BR>activity_ratings table created';
    }

    $types = query("SELECT * FROM strain_types", true);
    if(!enum_tables("ocs")){
        Query("CREATE TABLE `ocs` ( `id` INT NOT NULL AUTO_INCREMENT , `strain_id` INT NOT NULL , `shorttext` TEXT NOT NULL , `price` INT NOT NULL, `category` VARCHAR(255) NOT NULL , `plant` VARCHAR(255) NOT NULL , `terpenes` VARCHAR(512) NOT NULL , `content` TEXT NOT NULL , `available` TINYINT NOT NULL , `ocs_id` INT NOT NULL, `prices` TEXT , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
        echo '<BR>OCS table created';
    }
    if($forceupdate){
        echo '<BR>Full update requested. Deleting old and empty data';
        deleterow("ocs");
        deleterow("strains", 'name="" OR hasocs=2 OR slug LIKE "%-pre-roll"');
        Query("UPDATE strains SET hasocs = 0", false);
        Query("ALTER TABLE `ocs` DROP `prices`;");
        table_has_column("ocs", "prices", "TEXT");//$column, $type = false, $null = false, $default = false, $after = false, $isprimarykey = false, $comment
    }
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
                $data = import($strain, $data, $me, $types, $collection, $options);
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
