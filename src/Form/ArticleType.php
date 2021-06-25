<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use function Sodium\add;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if($options['ajouter']==true):// si on est dans ajout l'article on renvoi ce formulaire

        $builder
            ->add('nom',TextType::class , [
                "required"=> false,
                "label"=>false,
                "attr"=>[
                    "placeholder"=>"Saisir le nom"
                ]
            ])
            ->add('photo',FileType::class , [
                "required"=> false,
                "label"=>false,
                "constraints"=>[
                    new File([
                        "mimeTypes"=>[
                            "image/png",
                            "image/jpg",
                            "image/jpeg",
                            ],
                        "mimeTypesMessage"=>"Extensions autorisées: PNG, JPG, JPEG"
                    ])
                ],

            ])
            ->add('ref',TextType::class , [
                "required"=> false,
                "label"=>false,
                "attr"=>[
                    "placeholder"=>"Saisir la référence"
                ]
            ])

            ->add('prix',NumberType::class, [
                "required"=> false,
                "label"=>false,
                "attr"=>[
                    "placeholder"=>"Saisir le prix"
                ]
            ])
            ->add('description',TextType::class, [
                "required"=> false,
                "label"=>false,
                "attr"=>[
                    "placeholder"=>"Saisir la description"
                ]
            ])
            ->add('Valider', SubmitType::class)

            ->add('categorie', EntityType::class,[// selection option pour ajout d'article
                "label"=>false,
                "class" =>Categorie::class,
                "choice_label"=>"nom"// à quel champs de l'entité"

            ])

            ->add('photo2',FileType::class , [
                "required"=> false,
                "label"=>false,
                "constraints"=>[
                    new File([
                        "mimeTypes"=>[
                            "image/png",
                            "image/jpg",
                            "image/jpeg",
                        ],
                        "mimeTypesMessage"=>"Extensions autorisées: PNG, JPG, JPEG"
                    ])
                ],

            ])

            ->add('photo3',FileType::class , [
                "required"=> false,
                "label"=>false,
                "constraints"=>[
                    new File([
                        "mimeTypes"=>[
                            "image/png",
                            "image/jpg",
                            "image/jpeg",
                        ],
                        "mimeTypesMessage"=>"Extensions autorisées: PNG, JPG, JPEG"
                    ])
                ],

            ])
        ;


        elseif ($options['modifier']==true):// sinon si on est modification on renvoie ce formulaire
            $builder
                ->add('nom',TextType::class , [
                    "required"=> false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le nom"
                    ]
                ])
                ->add('photoModif',FileType::class , [
                    "required"=> false,
                    "label"=>false,
                    "constraints"=>[
                        new File([
                            "mimeTypes"=>[
                                "image/png",
                                "image/jpg",
                                "image/jpeg",
                            ],
                            "mimeTypesMessage"=>"Extensions autorisées: PNG, JPG, JPEG"
                        ])
                    ],

                ])
                ->add('ref',TextType::class , [
                    "required"=> false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir la référence"
                    ]
                ])

                ->add('prix',NumberType::class, [
                    "required"=> false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir le prix"
                    ]
                ])
                ->add('description',TextType::class, [
                    "required"=> false,
                    "label"=>false,
                    "attr"=>[
                        "placeholder"=>"Saisir la description"
                    ]
                ])
                ->add('Valider', SubmitType::class)

                ->add('categorie', EntityType::class,[// selection option pour ajout d'article
                    "label"=>false,
                    "class" =>Categorie::class,
                    "choice_label"=>"nom"// à quel champs de l'entité"

                ])

                ->add('imageFile2',FileType::class , [
                    "required"=> false,
                    "label"=>false,
                    "constraints"=>[
                        new File([
                            "mimeTypes"=>[
                                "image/png",
                                "image/jpg",
                                "image/jpeg",
                            ],
                            "mimeTypesMessage"=>"Extensions autorisées: PNG, JPG, JPEG"
                        ])
                    ],

                ])

                ->add('imageFile3',FileType::class , [
                    "required"=> false,
                    "label"=>false,
                    "constraints"=>[
                        new File([
                            "mimeTypes"=>[
                                "image/png",
                                "image/jpg",
                                "image/jpeg",
                            ],
                            "mimeTypesMessage"=>"Extensions autorisées: PNG, JPG, JPEG"
                        ])
                    ],

                ])
            ;

            endif;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'ajouter'=>false,
            'modifier'=>false
        ]);

    }
}
