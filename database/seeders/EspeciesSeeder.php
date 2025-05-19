<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class EspeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $especies = [
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Buteo magnirostris',
        'grupo' => 1,
        'rango_peligrosidad' => 'Moderado',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Buteo Nilidus',
        'grupo' => 1,
        'rango_peligrosidad' => 'Moderado',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Buteo platypterus',
        'grupo' => 1,
        'rango_peligrosidad' => 'Moderado',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Buteogallus anthracinus',
        'grupo' => 1,
        'rango_peligrosidad' => 'Alto',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Buteogallus meridionalis',
        'grupo' => 1,
        'rango_peligrosidad' => 'Alto',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Buteogallus urubitinga',
        'grupo' => 1,
        'rango_peligrosidad' => 'Muy Alto',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Elanus leucurus',
        'grupo' => 1,
        'rango_peligrosidad' => 'Moderado',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Gampsonyx swainsonii',
        'grupo' => 1,
        'rango_peligrosidad' => 'Bajo',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Ictinia mississippiensis',
        'grupo' => 1,
        'rango_peligrosidad' => 'Alto',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Milvago chimachima',
        'grupo' => 1,
        'rango_peligrosidad' => 'Moderado',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Pandion haliaetus',
        'grupo' => 1,
        'rango_peligrosidad' => 'Alto',
    ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Rana',
        'grupo' => 2, // Por ejemplo, 2 = ANFIBIOS
        'rango_peligrosidad' => 'Alto',
            ],
    [
        'nombre_comun' => '',
        'nombre_cientifico' => 'Sapo',
        'grupo' => 2, // Por ejemplo, 2 = ANFIBIOS
        'rango_peligrosidad' => 'Bajo',
    ],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Aramides cajanea', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Ardea albus', 'grupo' => 3, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Ardea cocoi', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Ardea herodias', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Bubulcus ibis', 'grupo' => 3, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Butorides striatus', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Butorides virescens', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Charadrius wilsonia', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Cochlearius panamensis', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Egretta caerulea', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Egretta thula', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Eudocimus albus', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Larus atricilla', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Laterallus exilis', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Mesembrinibis cayennensis', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Mycteria americana', 'grupo' => 3, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Nyctanassa violacea', 'grupo' => 3, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Nycticorax nycticorax', 'grupo' => 3, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Pilherodius pileatus', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Platalea ajaja', 'grupo' => 3, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Thalasseus maximus', 'grupo' => 3, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Trigrisoma fasciatum', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Trigrisoma mexicanum', 'grupo' => 3, 'rango_peligrosidad' => 'Bajo'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Antigone canadiensis', 'grupo' => 4, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Caladris mauri', 'grupo' => 4, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Caladris subruficolis', 'grupo' => 4, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Cathartes aura (M)', 'grupo' => 4, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Chaetura pelagica', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Coccyzus americanus', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Elanios', 'nombre_cientifico' => '', 'grupo' => 4, 'rango_peligrosidad' => 'Muy alto'],
            ['nombre_comun' => 'Gavilanes', 'nombre_cientifico' => '', 'grupo' => 4, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => 'Golondrinas', 'nombre_cientifico' => '', 'grupo' => 4, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Halcones', 'nombre_cientifico' => '', 'grupo' => 4, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Myiodynastes lutei', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Pheucticus ludovicianus', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Puffinus opisthomelas', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Setophaga fusca', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Surigma sibilatrix', 'grupo' => 4, 'rango_peligrosidad' => null],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyrannus dominicensis', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyrannus forficatus', 'grupo' => 4, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Víreo carmioli', 'grupo' => 4, 'rango_peligrosidad' => 'Bajo'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Asio clamator', 'grupo' => 5, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Ciccaba virgata', 'grupo' => 5, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Coccycua cayana', 'grupo' => 5, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Coccycua minuta', 'grupo' => 5, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Dromococcyx phasianellos', 'grupo' => 5, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Otus choliba', 'grupo' => 5, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyto alba', 'grupo' => 5, 'rango_peligrosidad' => 'Alto'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Actitis macularia', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Calidris minutilla', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Charadrius collaris', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Charadrius semipalmatus', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Himantopus mexicanus', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Numenius phaeopus', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Pluvialis dominica', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tringa melanoleuca', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tringa solitaria', 'grupo' => 6, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Vanellus chilensis', 'grupo' => 6, 'rango_peligrosidad' => 'Alto'],


            ['nombre_comun' => '', 'nombre_cientifico' => 'Drycopus lineatus', 'grupo' => 7, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Melanerpes rubricapillus', 'grupo' => 7, 'rango_peligrosidad' => 'Bajo'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Ortalis vetula', 'grupo' => 8, 'rango_peligrosidad' => 'Moderado'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Amazilia tzacatl', 'grupo' => 9, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Damophila julie', 'grupo' => 9, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Phaethornis striigularis', 'grupo' => 9, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Phaethornis superciliosus', 'grupo' => 9, 'rango_peligrosidad' => 'Bajo'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Cangrejos', 'grupo' => 10, 'rango_peligrosidad' => ''],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Crotophaga ani', 'grupo' => 11, 'rango_peligrosidad' => 'Bajo'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Cathartes aura', 'grupo' => 13, 'rango_peligrosidad' => 'Muy alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Cathartes burrovianus', 'grupo' => 13, 'rango_peligrosidad' => 'Muy alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Coragyps atratus', 'grupo' => 13, 'rango_peligrosidad' => null],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Hirundo rustica', 'grupo' => 14, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Petrochelidon fulva', 'grupo' => 14, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Petrochelidon pyrrhonata', 'grupo' => 14, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Progne chalybea', 'grupo' => 14, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Riparia riparia', 'grupo' => 14, 'rango_peligrosidad' => 'Bajo'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Caracara cheriway', 'grupo' => 15, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Falco femoralis', 'grupo' => 15, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Falco rufigularis', 'grupo' => 15, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Falco sparverius', 'grupo' => 15, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Falco peregrinus', 'grupo' => 15, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Herpetotheres cachinnans', 'grupo' => 15, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Micrastur semitorquatus', 'grupo' => 15, 'rango_peligrosidad' => 'Moderado'],

            ['nombre_comun' => '', 'nombre_cientifico' => 'Synallaxis albescens', 'grupo' => 16, 'rango_peligrosidad' => 'Bajo'],

            // ICTERIDOS
            ['nombre_comun' => '', 'nombre_cientifico' => 'Molothrus bonariensis', 'grupo' => 17, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Quiscalus mexicanus', 'grupo' => 17, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Sturnella magna', 'grupo' => 17, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Sturnella militaris', 'grupo' => 17, 'rango_peligrosidad' => 'Bajo'],

            // JILGUEROS
            ['nombre_comun' => '', 'nombre_cientifico' => 'Carduelis xanthogaster', 'grupo' => 19, 'rango_peligrosidad' => 'Bajo'],

            // LOROS Y PERICOS
            ['nombre_comun' => '', 'nombre_cientifico' => 'Amazona ochrocephala', 'grupo' => 20, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Brotogeris jugularis', 'grupo' => 20, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Pionus menstruus', 'grupo' => 20, 'rango_peligrosidad' => 'Moderado'],

             // MAMIFEROS
            ['nombre_comun' => 'Ardilla', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Armadillo', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Caballo', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Capibara', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Muy Alto'],
            ['nombre_comun' => 'Conejo', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Coyote', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Ganado', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Gato', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Grison', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Hormiguero', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Jaguarundi', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Mapache', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Murcielago', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Muy Alto'],
            ['nombre_comun' => 'Ocelote', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Perezoso.', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Perro', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Muy Alto'],
            ['nombre_comun' => 'Rata', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Ratones', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => 'Venado cola blanca', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Alto'],
            ['nombre_comun' => 'Zarigueya', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => 'Moderado'],
            ['nombre_comun' => 'Zorro gris', 'nombre_cientifico' => '', 'grupo' => 21, 'rango_peligrosidad' => null],

            // MARTÍN PESCADOR,
            ['nombre_comun' => '', 'nombre_cientifico' => 'Ceryle torquata', 'grupo' => 22, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Chloroceryle americana', 'grupo' => 22, 'rango_peligrosidad' => 'Bajo'],

            // MOSQUEROS
            ['nombre_comun' => '', 'nombre_cientifico' => 'Contopus virens', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Elaenia flavogaster', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Empidonax trailli', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Empidonax virescens', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Fluvicola pica', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Fluvicola virescens', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Megarynchus pitangua', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Myiarchus panamensis', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Myiodynastes maculatus', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Philohydor lictor', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Pitangus sulphuratus', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Todirostrum cinereum', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyrannus dominicensis', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyrannus melancholicus', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyrannus savana', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],
            ['nombre_comun' => '', 'nombre_cientifico' => 'Tyrannus tyrannus', 'grupo' => 23, 'rango_peligrosidad' => 'Bajo'],

            // PALOMAS
    ['nombre_comun' => '', 'nombre_cientifico' => 'Columba livia', 'grupo' => 24, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Columbia cayennens', 'grupo' => 24, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Columbina minuta', 'grupo' => 24, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Columbina talpacoti', 'grupo' => 24, 'rango_peligrosidad' => 'Muy Alto'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Leptotila verreauxi', 'grupo' => 24, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Patagioenas nigrirostris', 'grupo' => 24, 'rango_peligrosidad' => 'Bajo'],

    // PATOS, ZAMBU y JACANA
    ['nombre_comun' => '', 'nombre_cientifico' => 'Anas discors', 'grupo' => 25, 'rango_peligrosidad' => 'Moderado'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Anas platyrhynchos domesticus', 'grupo' => 25, 'rango_peligrosidad' => null],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Aramides cajanea', 'grupo' => 25, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Bartramia longicauda', 'grupo' => 25, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Cairina moschata', 'grupo' => 25, 'rango_peligrosidad' => 'Moderado'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Dendrocygna autumnalis', 'grupo' => 25, 'rango_peligrosidad' => 'Muy Alto'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Jacana jacana', 'grupo' => 25, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Laterales exilis', 'grupo' => 25, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Oxyura dominica', 'grupo' => 25, 'rango_peligrosidad' => 'Muy Alto'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Porphyrula martinica', 'grupo' => 25, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Porzana carolina', 'grupo' => 25, 'rango_peligrosidad' => 'Bajo'],

    // PAVOS
    ['nombre_comun' => '', 'nombre_cientifico' => 'Ortalis vetula', 'grupo' => 26, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'PAVONES', 'nombre_cientifico' => '', 'grupo' => 26, 'rango_peligrosidad' => null],

    // PINZONES
    ['nombre_comun' => '', 'nombre_cientifico' => 'Arremonops conirostrisis', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Oryzoborus funereus', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Oryzoborus minuta', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Sporophila americana', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Sporophila angolensis', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Sporophila minuta', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Tiaris olivacea', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Volatinia jacarina', 'grupo' => 28, 'rango_peligrosidad' => 'Bajo'],

    // PIQUEROS Y GAVIOTAS
    ['nombre_comun' => '', 'nombre_cientifico' => 'Chilodonias hirundo', 'grupo' => 29, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Chlidonias nigra', 'grupo' => 29, 'rango_peligrosidad' => null],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Fregata magnificens', 'grupo' => 29, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Larus atricilla', 'grupo' => 29, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Pelecanus occidentalis', 'grupo' => 29, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Phalacrocorax brasilianus', 'grupo' => 29, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Sterna hirundo', 'grupo' => 29, 'rango_peligrosidad' => 'Bajo'],

    // REINITAS
    ['nombre_comun' => '', 'nombre_cientifico' => 'Dendroica petechia', 'grupo' => 30, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Leiothlypis peregrina', 'grupo' => 30, 'rango_peligrosidad' => null],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Mniotilla vatia', 'grupo' => 30, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Seiurus noveboracensis', 'grupo' => 30, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Setophaga ruticilla', 'grupo' => 30, 'rango_peligrosidad' => 'Bajo'],

    // REPTILES
    ['nombre_comun' => 'Boa arcoiris', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Boa constrictor', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Caiman cocodrilus', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Moderado'],
    ['nombre_comun' => 'Coral falsa', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Coral verdadera', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Culebra', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Enuliophis sclateri', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Equis', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Iguana iguana', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Meracho', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Ojo de gato', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Patocas', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => 'Tortuga', 'nombre_cientifico' => '', 'grupo' => 31, 'rango_peligrosidad' => 'Bajo'],

    // SINSONTE
    ['nombre_comun' => '', 'nombre_cientifico' => 'Mimus gilvus', 'grupo' => 32, 'rango_peligrosidad' => 'Bajo'],

    // SOTORREYES
    ['nombre_comun' => '', 'nombre_cientifico' => 'Thryothorus modestus', 'grupo' => 33, 'rango_peligrosidad' => 'Bajo'],

    // TANGARAS
    ['nombre_comun' => '', 'nombre_cientifico' => 'Euphonia lanirostris', 'grupo' => 34, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Euphonia luteicapilla', 'grupo' => 34, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Ramphocelus dimidiatus', 'grupo' => 34, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Sicalis flaveola', 'grupo' => 34, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Thraupis episcopus', 'grupo' => 34, 'rango_peligrosidad' => 'Bajo'],

    // TAPACAMINOS
    ['nombre_comun' => '', 'nombre_cientifico' => 'Caprimulgus cayennensis', 'grupo' => 35, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Chordeiles acutipennis', 'grupo' => 35, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Chordeiles minor', 'grupo' => 35, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Chordeiles nacunda', 'grupo' => 35, 'rango_peligrosidad' => 'Bajo'],

    // TREPATRONCO
    ['nombre_comun' => '', 'nombre_cientifico' => 'Deconychura longicauda', 'grupo' => 36, 'rango_peligrosidad' => 'Bajo'],

    // TUCAN
    ['nombre_comun' => '', 'nombre_cientifico' => 'Ramphastos sulfuratus', 'grupo' => 37, 'rango_peligrosidad' => 'Bajo'],

    // VIREO
    ['nombre_comun' => '', 'nombre_cientifico' => 'Vireo flavoviridis', 'grupo' => 38, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Vireo leucophrys', 'grupo' => 38, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Vireo olivaceus', 'grupo' => 38, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Vireo philadelphicus', 'grupo' => 38, 'rango_peligrosidad' => 'Bajo'],

    // ZORZALES
    ['nombre_comun' => '', 'nombre_cientifico' => 'Cathartus ustulatus', 'grupo' => 39, 'rango_peligrosidad' => 'Bajo'],
    ['nombre_comun' => '', 'nombre_cientifico' => 'Turdus grayis', 'grupo' => 39, 'rango_peligrosidad' => 'Bajo'],



];


foreach ($especies as $especie) {
    DB::table('especies')->insert([
        'grupos_id' => $especie['grupo'],
        'nombre_comun' => $especie['nombre_comun'],
        'nombre_cientifico' => $especie['nombre_cientifico'],
        'rango_peligrosidad' => $especie['rango_peligrosidad'],
        'foto' => json_encode(['default.jpg']),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
    }
}
