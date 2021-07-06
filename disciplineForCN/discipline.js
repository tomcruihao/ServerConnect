var basicUrl = `https://search.ebscohost.com/login.aspx?authtype=ip,guest&profile=pfi&groupid=main&custid=s1397862&direct=true&db=edspub`;
var en_discipline = [
  {
    'category': '哲学',
    'disciplines': [
      {"discipline": "Anthropology", "queryParam": "LO system.dis-anth"},
      {"discipline": "Arts & Entertainment", "queryParam": "LO system.dis-arts"},
      {"discipline": "Dance", "queryParam": "LO system.dis-danc"},
      {"discipline": "Drama & Theater Arts", "queryParam": "LO system.dis-dram"},
      {"discipline": "Film", "queryParam": "LO system.dis-film"},
      {"discipline": "Music", "queryParam": "LO system.dis-musi"},
      {"discipline": "Religion & Philosophy", "queryParam": "LO system.dis-reli"},
      {"discipline": "Visual Arts", "queryParam": "LO system.dis-visu"},
    ]
  },
  {
    'category': '经济学',
    'disciplines': [
      {"discipline": "Business & Management", "queryParam": "LO system.dis-busi"},
      {"discipline": "Economics", "queryParam": "LO system.dis-econ"},
      {"discipline": "Marketing", "queryParam": "LO system.dis-mark"},
    ]
  },
  {
    'category': '法学',
    'disciplines': [
      {"discipline": "Law", "queryParam": "LO system.dis-lawx"},
      {"discipline": "Sociology", "queryParam": "LO system.dis-socy"},
      {"discipline": "Diplomacy & International Relations", "queryParam": "LO system.dis-dipl"},
      {"discipline": "Political Science", "queryParam": "LO system.dis-posc"},
      {"discipline": "Politics & Government", "queryParam": "LO system.dis-pogv"},
      {"discipline": "Ethnic & Cultural Studies", "queryParam": "LO system.dis-ethn"},
      {"discipline": "Social Work", "queryParam": "LO system.dis-sowo"},
      {"discipline": "Women's Studies & Feminism", "queryParam": "LO system.dis-wofe"},
    ]
  },
  {
    'category': '教育学',
    'disciplines': [
      {"discipline": "Education", "queryParam": "LO system.dis-educ"},
      {"discipline": "Psychology", "queryParam": "LO system.dis-psyc"},
      {"discipline": "Sports & Leisure", "queryParam": "LO system.dis-spls"},
    ]
  },
  {
    'category': '文学',
    'disciplines': [
      {"discipline": "Language & Linguistics", "queryParam": "LO system.dis-lang"},
      {"discipline": "Social Sciences & Humanities", "queryParam": "LO system.dis-sshu"},
      {"discipline": "Communication & Mass Media", "queryParam": "LO system.dis-comm"},
      {"discipline": "Literature & Writing", "queryParam": "LO system.dis-lite"},
    ]
  },
  {
    'category': '历史学',
    'disciplines': [
      {"discipline": "Biography", "queryParam": "LO system.dis-biog"},
      {"discipline": "Geography & Cartography", "queryParam": "LO system.dis-geog"},
      {"discipline": "History", "queryParam": "LO system.dis-hist"},
    ]
  },
  {
    'category': '理学',
    'disciplines': [
      {"discipline": "Mathematics", "queryParam": "LO system.dis-math"},
      {"discipline": "Science", "queryParam": "LO system.dis-scie"},
      {"discipline": "Astronomy & Astrophysics", "queryParam": "LO system.dis-astr"},
      {"discipline": "Biology", "queryParam": "LO system.dis-biol"},
      {"discipline": "Chemistry", "queryParam": "LO system.dis-chem"},
      {"discipline": "Earth & Atmospheric Sciences", "queryParam": "LO system.dis-eart"},
      {"discipline": "Environmental Sciences", "queryParam": "LO system.dis-envi"},
      {"discipline": "Geology", "queryParam": "LO system.dis-geol"},
      {"discipline": "Life Sciences", "queryParam": "LO system.dis-life"},
      {"discipline": "Oceanography", "queryParam": "LO system.dis-ocea"},
      {"discipline": "Physics", "queryParam": "LO system.dis-phys"},
    ]
  },
  {
    'category': '工学',
    'disciplines': [
      {"discipline": "Information Technology", "queryParam": "LO system.dis-info"},
      {"discipline": "Computer Science", "queryParam": "LO system.dis-comp"},
      {"discipline": "Library & Information Science", "queryParam": "LO system.dis-libr"},
      {"discipline": "Applied Sciences", "queryParam": "LO system.dis-appl"},
      {"discipline": "Architecture", "queryParam": "LO system.dis-arch"},
      {"discipline": "Biotechnology", "queryParam": "LO system.dis-biot"},
      {"discipline": "Construction & Building", "queryParam": "LO system.dis-cons"},
      {"discipline": "Engineering", "queryParam": "LO system.dis-engi"},
      {"discipline": "Power & Energy", "queryParam": "LO system.dis-powe"},
      {"discipline": "Technology", "queryParam": "LO system.dis-tech"},

    ]
  },
  {
    'category': '农学',
    'disciplines': [
      {"discipline": "Agriculture & Agribusiness", "queryParam": "LO system.dis-agri"},
      {"discipline": "Botany", "queryParam": "LO system.dis-bota"},
      {"discipline": "Forestry", "queryParam": "LO system.dis-fore"},
      {"discipline": "Zoology", "queryParam": "LO system.dis-zool"}
    ]
  },
  {
    'category': '医学',
    'disciplines': [
      {"discipline": "Anatomy & Physiology", "queryParam": "LO system.dis-anat"},
      {"discipline": "Complementary & Alternative Medicine", "queryParam": "LO system.dis-calm"},
      {"discipline": "Consumer Health", "queryParam": "LO system.dis-cohe"},
      {"discipline": "Dentistry", "queryParam": "LO system.dis-dent"},
      {"discipline": "Health & Medicine", "queryParam": "LO system.dis-heal"},
      {"discipline": "Nursing & Allied Health", "queryParam": "LO system.dis-nurs"},
      {"discipline": "Nutrition & Dietetics", "queryParam": "LO system.dis-nutr"},
      {"discipline": "Pharmacy & Pharmacology", "queryParam": "LO system.dis-phar"},
      {"discipline": "Physical Therapy & Occupational Therapy", "queryParam": "LO system.dis-ptot"},
      {"discipline": "Public Health", "queryParam": "LO system.dis-publ"},
      {"discipline": "Sports Medicine", "queryParam": "LO system.dis-spme"},
      {"discipline": "Veterinary Medicine", "queryParam": "LO system.dis-vetm"},
    ]
  },
  {
    'category': '军事学',
    'disciplines': [
      {"discipline": "Military History & Science", "queryParam": "LO system.dis-mili"},
    ]
  }
]
